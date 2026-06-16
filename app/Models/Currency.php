<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['code', 'symbol', 'exchange_rate', 'is_default', 'is_active'];

    protected $casts = [
        'exchange_rate' => 'double',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];
}
