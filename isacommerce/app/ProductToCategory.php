<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductToCategory extends Model
{
    protected $table = 'product_to_category';
    protected $fillable = [
        'id', 'product_id', 'category_id','created_at','updated_at'
    ];
}
