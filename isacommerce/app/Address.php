<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = [
        'id', 'address', 'city', 'postcode', 'country_id', 'province_id','created_at','updated_at'
    ];

    public function customer() {
        return $this->belongsTo('App\User');
    }
}
