<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model{

    protected $fillable = [
        'invoice_no',
        'first_name',
        'last_name',
        'email',
        'address', 
        'country',
        'state', 
        'zip', 
        'sub_total', 
        'total', 
        'discount' 
    ];

    public function items(){
        return $this->hasMany('App\Models\InvoiceItem');
    }
}