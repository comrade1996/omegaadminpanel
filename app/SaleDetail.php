<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price'];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Sales::class);
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'product_id');
    }

    public function getProducts()
    {
        $products = collect();
    }
}
