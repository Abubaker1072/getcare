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
        'banner_image',
        'is_active',
        'tags',
        'promo_text',
        'bullet_points',
        'features',
        'how_to_use',
        'ingredients',
        'faqs',
        'rating',
        'reviews_count',
        'purchased_count',
    ];

    protected $casts = [
        'bullet_points' => 'array',
        'features' => 'array',
        'faqs' => 'array',
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

    public function reviewVideos()
    {
        return $this->hasMany(ProductReviewVideo::class);
    }

    public function testimonials()
    {
        return $this->hasMany(ProductTestimonial::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
