<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotDealPromo extends Model
{
    protected $table = 'hot_deal_promos';

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'button_text',
        'button_url',
        'image_path',
        'video_path',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
