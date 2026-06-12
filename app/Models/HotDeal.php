<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotDeal extends Model
{
    protected $table = 'hot_deals';

    protected $fillable = ['product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
