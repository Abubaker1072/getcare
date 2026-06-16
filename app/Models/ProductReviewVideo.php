<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReviewVideo extends Model
{
    protected $fillable = [
        'product_id',
        'video_path',
        'caption',
        'is_active',
        'show_on_homepage',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
