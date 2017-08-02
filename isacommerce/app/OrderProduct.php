<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $fillable = [
        'id', 'order_id', 'product_id', 'product_name', 'quantity', 'price', 'total', 'created_at', 'updated_at'
    ];

    public function Order() {
        return $this->belongsTo('App\Order');
    }
}
