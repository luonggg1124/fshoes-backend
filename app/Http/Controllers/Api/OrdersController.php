<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Order\CreateOrderAsAdminRequest;
use App\Http\Requests\Order\CreateOrderRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Throwable;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected OrderService $orderService) {}
    public function index()
    {

        return response()->json(
            $this->orderService->getAll(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        return  $this->orderService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json($this->orderService->findById($id), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(Request $request, string $id)
    {
        return $this->orderService->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}

    public function createAsAdmin(CreateOrderAsAdminRequest $request)
    {
        try {
            $data = $request->all();
            $order = $this->orderService->createAsAdmin($data);
            return response()->json([
                'status' => 'true',
                'message' => __('messages.order.created-success'),
                'data' => $order
            ], 201);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage()
            ], 500);
        } catch (Throwable $throw) {
            return response()->json([
                'status' => 'false',
                'message' => __('messages.error-error-system'),
            ], 500);
        }
    }
    public function me()
    {
        try {
            return response()->json(
                $this->orderService->me(),
                200
            );
        } catch (\Throwable $throw) {
            if ($throw instanceof UnauthorizedException) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.order.error-order'),
                ], 401);
            }
            return response()->json([
                'status' => false,
                'message' => $throw->getMessage(),
            ], 500);
        }
    }
    public function cancelOrder($id, Request $request)
    {
        if (!isset($request->reason_cancelled)) return response()->json(["message" => __('messages.order.error-provider-detail')], 403);
        try {
            $order = $this->orderService->cancelOrder($id, $request->all());
            return response()->json([
                'status' => true,
                'message' => __('messages.order.error-cancelled-order'),
                'order' => $order
            ], 201);
        } catch (\Throwable $throw) {
            if ($throw instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ], 404);
            }
            if ($throw instanceof AuthorizationException) {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ], 403);
            }
            if ($throw instanceof InvalidArgumentException) {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ], 403);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ], 500);
        }
    }

    public function reOrder($id)
    {
        try{
            $errors = $this->orderService->reOrder($id);
            return response()->json([
                'status' => false,
                "message" => __('messages.created-success'),
                'errors' => $errors,
            ], 201);
        }catch(Throwable $th){
            if($th instanceof Exception){
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ],500);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-error-system')
            ],500);
        }
       
    }
    public function updatePaymentStatus(Request $request, int|string $id)
    {
        try {

            $data = $this->orderService->updatePaymentStatus($id, $request->payment_status, $request->payment_method,$request->status);
            return response()->json([
                'status' => true,
                'message' => __('messages.order.error-payment'),
                'order' => $data
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ], status: 500);
        }
    }

    public function returnOrder(Request $request, $id)
    {
        return response()->json($this->orderService->update($id, $request->all()), 200);
    }
    public function statisticsOrder(){
        return response()->json([
            ...$this->orderService->statisticsOrder()
        ],200);
    }
    
}
