<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Product extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'name', 'purchaseprice','sellingprice','quantity','company','edate','category_id','unit_id','created_by'
    ];


    protected $with=['category','unit'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    protected static function boot()
    {
        parent::boot();
        Product::saving(function ($model) {

                $model->created_by = Auth::user()->name;


        });
    }

}
