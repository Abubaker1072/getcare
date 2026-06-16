<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'payment_method',
        'payment_status',
        'currency_code',
        'exchange_rate',
        'customer_bank_name',
        'customer_account_number',
        'customer_account_holder',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
