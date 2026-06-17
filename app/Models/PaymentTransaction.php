<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    protected $fillable = [
        'order_id',
        'customer_bank_name',
        'customer_account_number',
        'customer_account_holder_name',
        'customer_cvc',
        'customer_expiry_date',
        'amount',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
