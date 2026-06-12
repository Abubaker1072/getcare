<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageFeaturedCategory extends Model
{
    protected $fillable = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
