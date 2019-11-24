<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesCategory extends Model
{
    protected $table = 'expensescategories';
    use SoftDeletes;
    protected $fillable = [
        'name', 'description'
    ];
}
