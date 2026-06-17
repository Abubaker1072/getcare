<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetail extends Model
{
    protected $table = 'user_bank_details';

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_holder_name',
        'cvc',
        'expiry_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
