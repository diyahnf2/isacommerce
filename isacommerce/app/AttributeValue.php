<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_value';
    protected $fillable = [
        'id', 'value', 'created_at','updated_at'
    ];

    public function attribute() {
        return $this->belongsTo('App\Attribute');
    }
}
