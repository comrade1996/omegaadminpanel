<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class MissingItem extends Model
{
    protected $table = 'missingitems';
    use SoftDeletes;
    protected $fillable = [
        'name', 'description','created_by'
    ];


    protected static function boot()
    {
        parent::boot();
        MissingItem::saving(function ($model) {

                $model->created_by = Auth::user()->name;


        });
    }

}
