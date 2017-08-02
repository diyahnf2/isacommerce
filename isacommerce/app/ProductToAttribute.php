<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductToAttribute extends Model
{
    protected $table = 'product_to_attribute';
    protected $fillable = [
        'id', 'product_id', 'attribute_id', 'value_id','created_at','updated_at'
    ];
}
