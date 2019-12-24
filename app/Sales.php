<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Sales extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subtotal','discount','grandtotal','id','created_by'
    ];



    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    protected static function boot()
    {
        parent::boot();
        Sales::saving(function ($model) {

                $model->created_by = Auth::user()->name;


        });
    }


}
