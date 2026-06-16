<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'rating',
        'title',
        'text',
        'product_name',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
}
