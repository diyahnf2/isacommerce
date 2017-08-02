<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = [
        'id', 'invoice_no', 'customer_id', 'firstname', 'lastname', 'email', 'phone', 'address', 'city', 'postcode', 'country_id', 'province_id', 'comment', 'total', 'order_status_id', 'created_at'
    ];

    public function orderProduct() {
        return $this->hasMany('App\OrderProduct');
    }
}
