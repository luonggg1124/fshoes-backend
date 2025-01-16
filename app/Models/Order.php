<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use HasFactory;
    protected $table='orders';
    protected $fillable=[
        "id",
        "user_id",
        "payment_method",
        "payment_status",
        "shipping_method",
        "shipping_cost",
        "tax_amount",
        "amount_collected",
        "note",
        "receiver_full_name",
        "receiver_email",
        "phone",
        "city",
        "country",
        "voucher_id",
        "address",
        "total_amount",
        "status",
        "reason_cancelled",
        "reason_return",
        "reason_denied_return",
        'created_at',
        'updated_at',
    ];




    public function orderDetails():HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }
    public function orderHistory() : HasMany
    {
            return $this->hasMany(OrderHistory::class );
    }
     public function user():BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function voucher():BelongsTo
    {
        return $this->belongsTo(Voucher::class)->withTrashed();
    }

}
