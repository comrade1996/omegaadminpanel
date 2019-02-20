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


    protected $with=['category'];
    public function

    category()
    {
        return $this->belongsTo('App\Category');
    }


}
