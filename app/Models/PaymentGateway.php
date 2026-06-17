<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $table = 'payment_gateways';

    protected $fillable = [
        'admin_bank_name',
        'admin_account_number',
        'admin_account_holder_name',
        'admin_cvc',
        'admin_expiry_date',
    ];
}
