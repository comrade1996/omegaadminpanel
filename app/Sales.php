<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subtotal','discount','grandtotal','id'
    ];



    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }


}
