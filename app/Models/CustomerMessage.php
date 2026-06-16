<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'inquiry_type',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
