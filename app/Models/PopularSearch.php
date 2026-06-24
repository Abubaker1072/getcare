<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularSearch extends Model
{
    protected $fillable = ['name', 'image', 'is_hot', 'sort_order'];
}
