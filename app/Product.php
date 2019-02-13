<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'purchaseprice','sellingprice','quantity','company','edate','category_id'
    ];


    public function category()
    {
        return $this->hasOne('App\Category');
    }
}
