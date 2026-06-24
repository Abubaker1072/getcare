<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarqueeImage extends Model
{
    protected $table = 'marquee_images';

    protected $fillable = [
        'image_path',
        'link_url',
        'title',
        'sort_order',
        'is_active',
    ];
}
