<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpensesCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'description'
    ];
}
