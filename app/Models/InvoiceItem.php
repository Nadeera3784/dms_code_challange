<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model{

    protected $fillable = [
        'price',
        'quantity',
        'price',
        'total', 
        'product_id' 
    ];

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}