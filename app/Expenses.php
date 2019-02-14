<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'amount','expensescategory_id'
    ];


    public function expensescategory()
    {
        return $this->hasOne('App\ExpensesCategory');
    }
}
