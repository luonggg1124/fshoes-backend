<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all()->pluck('id');
        $user = User::query()->find(1);
        $usersEmail = User::all()->pluck('email')->toArray();
        $userName = User::all()->pluck('name')->toArray();
        for($i = 1; $i <= 100; $i++){
           Order::query()->create([
                'user_id' => random_int(1,count($users)),
                'total_amount' => 1,
                'payment_method' => 'Banking',
                'payment_status' => 'paid',
                'shipping_method' => 'test',
                'shipping_cost' => 10000,
                'amount_collected' => 100000,
                'receiver_full_name' => 'Luong Nguyen',
               'receiver_email'=> 'luongnm1124@gmail.com',
                'address' => 'Nhuận Trạch - Vạn Thắng - Ba Vì - Hà Nội',
                'phone' => '0989329401',
                'city' => 'Hà Nội',
                'country' => 'Việt Nam',
                'status' => rand(0,6),
                'created_at' => Carbon::now()->subYear()->addDays(rand(0, 365)),
                'updated_at' => Carbon::now()
            ]);
        }
        $orders = Order::all();
        foreach ($orders as $order){
            $products = Product::all();
            $total = 0;
            foreach ($products as $p) {
                $pro = Product::query()->find(random_int(1,count($products)));
                if(!$pro) break;
                if($pro->is_variant){
                    $variant = $pro->variations[0];
                    $attributes = [];
                    foreach($variant->values as $v){
                        $attributes[$v->attribute->name] = $v->value;
                    }                    
                    $orderDetail = OrderDetails::query()->create([
                        'order_id' => $order->id,
                        'product_variation_id' =>  $variant->id,
                        'product_id' => null,
                        'price' => $pro->variations()->first()->price ,
                        'quantity' => 1,
                        'total_amount' => $pro->variations()->first()->price,
                        "detail_item" => json_encode($attributes)
                    ]);
                    $total += $orderDetail->total_amount;
                }else {
                    $orderDetail = OrderDetails::query()->create([
                        'order_id' => $order->id,
                        'product_variation_id' =>  null,
                        'product_id' => $pro->id,
                        'price' => $pro->price ,
                        'quantity' => 1,
                        'total_amount' => $pro->price,
                    ]);
                    $total += $orderDetail->total_amount;
                }
            }
            $order->total_amount = $total;
            $order->amount_collected = $order->total_amount + $order->shipping_cost;
            $order->save();
        }
    }
}
