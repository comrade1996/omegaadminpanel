<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{

    protected $userstamps = [
       'created_by',
       'updated_by',
       'submitted_by',
       'deleted_by'
    ];

    use SoftDeletes;
    protected $fillable = [
        'name', 'description','created_by'
    ];


    protected static function boot()
    {
        parent::boot();
        Company::saving(function ($model) {

                $model->created_by = Auth::user()->name;


        });
    }
}
