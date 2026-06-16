<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTestimonial extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'caption',
        'short_description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
