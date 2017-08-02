<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $fillable = [
        'id', 'name', 'description', 'created_at','updated_at'
    ];

    public function attribute_value() {
        return $this->hasMany('App\AttributeValue');
    }
}
