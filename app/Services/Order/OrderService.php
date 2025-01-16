<?php

namespace App\Services\Order;


use Exception;
use App\Models\Cart;
use App\Jobs\PaidOrder;
use App\Models\Voucher;
use App\Jobs\CancelOrder;

use App\Http\Traits\Paginate;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\OrdersCollection;
use Illuminate\Validation\UnauthorizedException;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\OrderHistory\OrderHistoryServiceInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use App\Repositories\Product\Variation\VariationRepositoryInterface;

use Illuminate\Support\Facades\DB;


class OrderService implements OrderServiceInterface
{
    use Paginate;
    protected $cacheTag = 'orders';
    private array $relations = ['products', 'variations', 'statistics'];
    public function __construct(
        protected OrderRepositoryInterface       $orderRepository,
        protected OrderDetailRepositoryInterface $orderDetailRepository,
        protected OrderHistoryServiceInterface   $orderHistoryService,
        protected ProductRepositoryInterface     $productRepository,
        protected VariationRepositoryInterface   $variationRepository,
        protected CartRepositoryInterface        $cartRepository,
        protected UserRepositoryInterface        $userRepository,
    ) {}

    public function getAll()
    {
        $listStatus = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $status = request()->get('status');
        if (!in_array($status, $listStatus)) {
            $status = '';
        }
        $search = request()->get('search');

        $perPage = request()->query('per_page');
        $orders = $this->orderRepository->query()
            ->with([
                'orderDetails',
                'orderHistory',
                'user.image',
                'orderDetails.variation.images',
                'orderDetails.variation.product',
                'orderDetails.product.images',
                'voucher',
            ])->when(
                $status || $status != '',
                function ($q) use ($status) {
                    $q->where('status', $status);
                }
            )
            ->when($search, function ($q) use ($search) {
                $q->where('receiver_email', 'like', '%' . $search . '%')->orWhere('id', 'like', '%' . $search . '%');
            })
            ->orderBy('updated_at', 'desc')->paginate(is_numeric($perPage) ? $perPage : 10);
        return [
            'paginator' => $this->paginate($orders),
            'data' => OrdersCollection::collection(
                $orders->items()
            ),
        ];;
    }

    public function findById(int|string $id)
    {
        $order = $this->orderRepository->query()->where('id', $id)->with(["orderDetails", 'orderHistory', 'user', 'user.image', 'orderDetails.variation', 'orderDetails.product', 'voucher'])->first();
        if (!$order) {
            throw new ModelNotFoundException(__('messages.error-not-found'));
        }
        return new OrdersCollection($order);
    }

    /**
     * @throws \Exception
     */
    public function create(array $data, array $option = [])
    {
        try {
            foreach ($data['order_details'] ?? [] as $detail) {
                if ($detail["product_id"]) {
                    $item = $this->productRepository->query()->where('id', $detail["product_id"])->first();
                } else {
                    $item = $this->variationRepository->query()->where('id', $detail["product_variation_id"])->first();
                }
                if ($item->stock_qty - $detail["quantity"] <= 0) {
                    if ($detail["product_id"]) {
                        $message = __('messages.cart.product_word') . $item->name . __('messages.cart.out_of_stock') . $item->stock_qty .  __('messages.cart.units');
                    } else  $message = __('messages.cart.variations_word') . $item->name . __('messages.cart.out_of_stock') . $item->stock_qty .  __('messages.cart.units');
                }
            }

            if (isset($data["voucher_id"])) {
                $voucher = Voucher::find($data["voucher_id"]);
                $voucher->quantity--;
                if(isset(request()->user()->id)){
                    $voucher->users()->attach(request()->user()->id);
                }
                if ($voucher->quantity < 0) return response()->json(["message" => __('messages.voucher.error-voucher')], 500);
                $voucher->save();
            }
            $order = $this->orderRepository->create($data);
            if($order->status  == "1"){
                CancelOrder::dispatch($order->id)->delay(now()->addMinutes(1));
            }
            foreach ($data['order_details'] ?? [] as $detail) {
                $detail['order_id'] = $order->id;
                $this->orderDetailRepository->create($detail);
                if ($detail["product_id"]) {
                    $item = $this->productRepository->query()->where('id', $detail["product_id"])->first();
                } else {
                    $item = $this->variationRepository->query()->where('id', $detail["product_variation_id"])->first();
                }

                if ($item->currentSale()) {
                    $item->sales()->updateExistingPivot($item->currentSale()->id, [
                        'quantity' => $item->currentSale()->pivot->quantity + $detail["quantity"],
                    ]);
                }
                $item->save();
            }
            if (request()->user()) {
                $this->orderHistoryService->create(["order_id" => $order->id, "user_id" => null, "description" => request()->user()->name . " created order"]);
            } else $this->orderHistoryService->create(["order_id" => $order->id, "user_id" => null, "description" => "Guess  created order"]);

            if (isset($data['cart_ids'])) {
                foreach ($data['cart_ids'] as $id) {
                    $this->cartRepository->delete($id);
                }
            }

            dispatch(new \App\Jobs\CreateOrder($order->id, $order->receiver_email))->delay(now()->addSeconds(2));
            Cache::tags([$this->cacheTag, ...$this->relations])->flush();
            return response()->json([
                "message" => __('messages.created-success'),
                'order' => $order
            ], 201);
        } catch (Exception $e) {
            logger()->error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function createAsAdmin(array $data)
    {
        return DB::transaction(function()use($data){
            $user = null;
            if(isset($data['user_id']) && $data['user_id'] != 0){
                $user = $this->userRepository->find($data['user_id']);
                if(!$user){
                    throw new ModelNotFoundException(__('messages.create_order_as_admin.not_found_user'));
                }
            }
            if (isset($data["voucher_id"])) {
                $voucher = Voucher::find($data["voucher_id"]);
                if ($voucher->quantity < 0) throw new Exception(__('messages.voucher.error-voucher'));
                $voucher->quantity--;
                if($user){
                    $voucher->users()->attach($user->id);
                }
                $voucher->save();
            }
            
            $order = $this->orderRepository->create($data);
            if($user){
                $this->orderHistoryService->create(["order_id" => $order->id, "user_id" => $user->id, "description" => $user->name . " created order"]);
            }else {
                $this->orderHistoryService->create(["order_id" => $order->id, "user_id" => null, "description" => "Guess created order"]);
            }
            if(!$order){
                throw new Exception(__('messages.create_order_as_admin.cannot_create'));
            }
            
            foreach ($data['order_details'] ?? [] as $detail) {
                if ($detail["product_id"]) {
                    $item = $this->productRepository->find($detail['product_id']);
                    if(!$item){
                        throw new ModelNotFoundException(__('messages.create_order_as_admin.not_found_product'));
                    }
                    if($item->stock_qty < $detail['quantity']){
                        throw new InvalidArgumentException($item->name.__("messages.create_order_as_admin.out_of_stock"));
                    }
                    $item->stock_qty = $item->stock_qty - $detail['quantity'];
                    $item->qty_sold = $item->qty_sold + $detail['quantity'];
                    if ($item->currentSale()) {
                        $item->sales()->updateExistingPivot($item->currentSale()->id, [
                            'quantity' => $item->currentSale()->pivot->quantity + $detail["quantity"],
                        ]);
                    }
                    $orderDetail = $this->orderDetailRepository->create([
                        'order_id' => $order->id,
                        'product_variation_id' => null,
                        'product_id' => $item->id,
                        'price' => $detail['price'],
                        'total_amount' => $detail['total_amount'],
                        'detail_item' => $detail['detail_item'] ?? null,
                        'quantity' => $detail['quantity'],
                    ]);
                    if(!$orderDetail){
                        throw new Exception(__('messages.create_order_as_admin.cannot_create'));
                    }
                    $item->save();
                } else {
                    $item = $this->variationRepository->find($detail["product_variation_id"]);
                    if(!$item){
                        throw new ModelNotFoundException(__('messages.create_order_as_admin.not_found_product'));
                    }
                    if($item->stock_qty < $detail['quantity']){
                        throw new InvalidArgumentException($item->name.__("messages.create_order_as_admin.out_of_stock"));
                    }
                    $item->stock_qty = $item->stock_qty - $detail['quantity'];
                    $item->qty_sold = $item->qty_sold + $detail['quantity'];
                    if ($item->currentSale()) {
                        $item->sales()->updateExistingPivot($item->currentSale()->id, [
                            'quantity' => $item->currentSale()->pivot->quantity + $detail["quantity"],
                        ]);
                    }
                    $orderDetail = $this->orderDetailRepository->create([
                        'order_id' => $order->id,
                        'product_variation_id' => $item->id,
                        'product_id' => null,
                        'price' => $detail['price'],
                        'total_amount' => $detail['total_amount'],
                        'detail_item' => $detail['detail_item'] ?? null,
                        'quantity' => $detail['quantity'],
                    ]);
                    if(!$orderDetail){
                        throw new Exception(__('messages.create_order_as_admin.cannot_create'));
                    }
                    $item->save();
                }
                
            }
            if($order->receiver_email){
                dispatch(new \App\Jobs\CreateOrder($order->id, $order->receiver_email))->delay(now()->addSeconds(2));
            }
            
            Cache::tags([$this->cacheTag, ...$this->relations])->flush();
            return $order;
        });
       

      
        
    }
    public function update(int|string $id, array $data, array $option = [])
    {
        if (isset($data["status"]) && $data["status"] == "0" && !isset($data["reason_cancelled"])) {
            return response()->json(["message" => __('messages.order.error-specific')], 403);
        }
        try {
            $order = $this->orderRepository->find($id);
            $orderDetails = $this->orderDetailRepository->query()->where('order_id', $id)->get();

            DB::transaction(function()use($data,$orderDetails,$order){
                foreach ($orderDetails as $detail) {
                    if ($detail['product_id']) {
                        $item = $this->productRepository->query()->withTrashed()->where('id', $detail["product_id"])->first();
                    } else $item = $this->variationRepository->query()->withTrashed()->where('id', $detail["product_variation_id"])->first();
                    if($data['status'] > 0 && $data['status'] === 3){
                        if($item->stock_qty < $detail['quantity']){
                            throw new Exception(__("messages.update-order-out-of-qty"));
                        }
                    }
                    if ($data["status"] == 3) {
                        $item->stock_qty = $item->stock_qty - $detail["quantity"];
                        $item->qty_sold = $item->qty_sold + $detail["quantity"];
                    }

                    if ($data["status"] == 0) {
                        $item->stock_qty = $item->stock_qty + $detail["quantity"];
                        $item->qty_sold = $item->qty_sold - $detail["quantity"] > 0 ? $item->qty_sold - $detail["quantity"] : 0;
                    }
                    $item->save();
                }
            });
            $order = $this->orderRepository->update($id, $data);
            $message = "";
            switch ($data["status"]) {
                case 0:
                    $message = (request()->user()->name ? "User " . request()->user()->name : "Guess") . " cancelled order";
                    break;
                case 2:
                    $message = __('messages.order.error-confirmed');
                    break;
                case 3:
                    $message = __('messages.order.error-delivered');
                    break;
                case 4:
                    $message = __('messages.order.error-was-delivered');
                    break;
                case 5:
                    $message = __('messages.order.error-processing');
                    break;
                case 6:
                    $message = __('messages.order.error-returned-processing');
                    break;
                case 7:
                    $message = __('messages.order.error-returned');
                    break;
            }
            Cache::tags([$this->cacheTag, ...$this->relations])->flush();
            $this->orderHistoryService->create(["order_id" => $id, "user_id" => null, "description" => $message]);
            return response()->json(["message" => __('messages.update-success')], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => __('messages.order.error-can-not-order')], 500);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function me()
    {
        $listStatus = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $status = request()->query('status');
        $perPage = request()->query('per_page');
        if (!in_array((int)$status, $listStatus)) {
            $status = null;
        }
        if (!is_int((int)$perPage) || $perPage < 0) {
            $perPage = 10;
        }

        $user = $this->userRepository->find(request()->user()->id);
        if (!$user) throw  new UnauthorizedException(__('messages.order.error-order'));
        $orders = $user->orders()->when(
            $status !== null,
            function ($query) use ($status) {

                $query->where('status', $status);
            }
        )->with(['orderHistory'])->orderBy('created_at', 'desc')->paginate($perPage);
        return
            [
                'paginator' => $this->paginate($orders),
                'data' => OrdersCollection::collection(
                    $orders->items()
                ),
            ];
    }

    public function cancelOrder($id, $data)
    {
        $order = $this->orderRepository->find($id);
        
        $user = request()->user();
        if ($order->user_id != $user->id) throw new AuthorizationException(__('messages.order.error-can-not-order'));
        if (!$order) throw new ModelNotFoundException(__('messages.error-not-found'));
        if ($order->status > 2 || $order->status === 0) throw new InvalidArgumentException(__('messages.order.error-can-not-order'));

        $voucher = $order->voucher;
        $items = $order->orderDetails;
        if ($items) {
            foreach ($items as $item) {
                if ($order->status > 2) {
                    if ($item->product_variation_id) {
                        $variation = $this->variationRepository->find($item->product_variation_id);
                        if ($variation) {
                            $variation->stock_qty += $item->quantity;
                            $variation->qty_sold -= $item->quantity;
                            $variation->save();
                        }
                    } else if ($item->product_id) {
                        $product = $this->productRepository->find($item->product_id);
                        if ($product) {
                            $product->stock_qty += $item->quantity;
                            $product->qty_sold -= $item->quantity;
                            $product->save();
                        }
                    }
                }
            }
        }
        if ($voucher) {
            $user->voucherUsed()->detach([$voucher->id]);
        }
        $order->status = 0;
        $order->reason_cancelled = $data["reason_cancelled"];
        $order->save();
        Cache::tags([$this->cacheTag, ...$this->relations])->flush();
        return new OrdersCollection($order);
    }

    public function reOrder($id)
    {
        $errors = [];
        $order = $this->orderRepository->find($id);
        if(!$order){
            throw new ModelNotFoundException('Không tìm thấy order');
        }
        $user = request()->user();
        if ($order->user_id != $user->id) throw new AuthorizationException('Không được phép!');
        foreach ($order->orderDetails as $item) {
            if ($item->product_variation_id) {
                $variation = $this->variationRepository->find($item->product_variation_id);
                $product = $this->productRepository->find($variation->product->id);
                if ($variation && $product) {
                   
                    if($variation->stock_qty > 0 && $variation->stock_qty >= $item->quantity && $variation->status !== false){
                       
                        $cart = $user->carts()->where('product_variation_id',$variation->id)->first();
                        if($cart){
                            
                            if($variation->stock_qty < $cart->quantity){
                                $cart->quantity = $variation->stock_qty;
                                $cart->save();
                            }
                        }else{
                           
                            Cart::create([
                                "user_id" => request()->user()->id,
                                "product_variation_id" => $variation->id,
                                "product_id" =>  null,
                                "quantity" => $item->quantity
                            ]);
                        }
                       
                    }else{
                        $errors['variation_qty'][] = $variation->name. __('messages.order.error-variation');
                    }
                }
            } else{
                
                $product = $this->productRepository->find($item->product_id);
                if(!$product) throw new ModelNotFoundException('Không tìm thấy sản phẩm!');
                if ($product) {
                    if($product->stock_qty >= $item->quantity && $product->status !== false){
                        $cart = $user->carts()->where('product_id',$product->id)->first();
                        if($cart){
                            if($product->stock_qty < $cart->quantity){
                                $cart->quantity = $product->stock_qty;
                                $cart->save();
                            }
                        }else{
                            Cart::create([
                                "user_id" => request()->user()->id,
                                "product_variation_id" => null,
                                "product_id" =>   $product->id,
                                "quantity" => $item->quantity
                            ]);
                        }   
                        
                    }else {
                        $errors['product_qty'][] = $product->name. __('messages.order.error-variation');
                    }
                   
                }
            }
        }
        Cache::tags([$this->cacheTag, ...$this->relations])->flush();
        return $errors;
    }
    public function updatePaymentStatus(int|string $id, $paymentStatus = true, $paymentMethod = 'cash_on_delivery',$orderStatus = 2)
    {
        $order = $this->orderRepository->find($id);
        if (!$order) throw new ModelNotFoundException(__('messages.error-not-found'));

        if ($paymentStatus) {
            $order->payment_status = 'paid';
        } else {
            $order->payment_status = 'not_yet_paid';
        }
        $order->status = $orderStatus;
        $order->payment_method = $paymentMethod;
        $order->save();
        if ($order->payment_status) {
            dispatch(new PaidOrder($order->id, $order->receiver_email))->delay(now()->addSeconds(2));
        }
        Cache::tags([$this->cacheTag, ...$this->relations])->flush();
        return $order;
    }
    public function statisticsOrder(){
        return [
            'total_order' => $this->orderRepository->query()->count(),
            'total_order_cancelled' => $this->orderRepository->query()->where('status',0)->count(),
            'total_order_waiting_payment' =>  $this->orderRepository->query()->where('status',1)->count(),
            'total_order_waiting_confirm' => $this->orderRepository->query()->where('status',2)->count(),
            'total_order_confirmed' => $this->orderRepository->query()->where('status',3)->count(),
            'total_order_delivering'=> $this->orderRepository->query()->where('status',4)->count(),
            'total_order_delivered' => $this->orderRepository->query()->where('status',5)->count(),
            'total_order_waiting_accept_return' => $this->orderRepository->query()->where('status',6)->count(),
            'total_order_return_processing' => $this->orderRepository->query()->where('status',7)->count(),
            'total_order_denied_return' => $this->orderRepository->query()->where('status',8)->count(),
            'total_order_returned' => $this->orderRepository->query()->where('status',9)->count(),
        ];
    }
}
