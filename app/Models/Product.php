<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'image',
        'price',
        'author',
        'description',
        'in_stock'

    ];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}