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
        'product_id',
        'is_approved',
        'show_on_homepage',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
