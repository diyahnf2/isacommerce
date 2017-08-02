<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'id', 'parent_id', 'category_name', 'category_seo', 'category_meta_title', 'category_meta_description','category_meta_keyword','status','viewed','created_at','updated_at'
    ];
}
