<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';
    protected $fillable = [
        'id', 'product_id', 'is_active', 'discount_operation', 'discount_amount', 'expiry','created_at','updated_at'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}

