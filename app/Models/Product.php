<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'discount_price',
        'stock',
        'image',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'cover_image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function homepageBestselling()
    {
        return $this->hasOne(HomepageBestsellingProduct::class);
    }

    public function homepageHotDeal()
    {
        return $this->hasOne(HotDeal::class);
    }

    public function reels()
    {
        return $this->hasMany(Reel::class);
    }
}
