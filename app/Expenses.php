<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Expenses extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount','expensescategory_id','created_by'
    ];

    protected $with=['expensescategory'];
    public function expensescategory()
    {
        return $this->belongsTo('App\ExpensesCategory');
    }

    protected static function boot()
    {
        parent::boot();
        Expenses::saving(function ($model) {

                $model->created_by = Auth::user()->name;


        });
    }

}
