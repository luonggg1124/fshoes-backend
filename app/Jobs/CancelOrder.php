<?php

namespace App\Jobs;

use Exception;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\ProductVariations;
use Illuminate\Support\Facades\Log;
use App\Services\Order\OrderService;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class CancelOrder implements ShouldQueue
{
    use Queueable;

    private $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      try{
        $order = Order::find($this->id);
        if($order->status == 1){
            $order->status = 0;
            $order->save();
        }
      }catch(Throwable $e){
        Log::error(
            message: __CLASS__ . '@' . __FUNCTION__,
            context: [
                'line' => $e->getLine(),
                'message' => $e->getMessage()
            ]
        );
      }
    }
}
