<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'id', 'sku', 'upc', 'product_name', 'product_seo', 'product_meta_title','product_meta_description','product_meta_keyword','product_description','price', 'weight', 'quantity','min_quantity','subtract_quantity','status','viewed','created_at','updated_at'
    ];

    public function discount() {
        return $this->hasOne('App\Discount'); // this matches the Eloquent model
    }
}
