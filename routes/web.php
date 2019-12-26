<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::prefix('api')->middleware('auth')->group(function () {
    Route::apiResources(['category'=>'API\CategoryController']);
    Route::apiResources(['user'=>'API\UserController']);
    Route::apiResources(['unit'=>'API\UnitController']);
    Route::apiResources(['expensescategory'=>'API\ExpensesCategoryController']);
    Route::apiResources(['missingitem'=>'API\MissingItemController']);
    Route::apiResources(['expenses'=>'API\ExpensesController']);
    Route::apiResources(['sales'=>'API\SalesController']);
    Route::apiResources(['salesdetails'=>'API\SalesDetailsController']);
    Route::apiResources(['product'=>'API\ProductController']);
    Route::get('findUser','API\UserController@search');
    Route::get('findCategory','API\CategoryController@search');
    Route::get('findUnit','API\UnitController@search');
    Route::get('findExpensesCategory','API\ExpensesCategoryController@search');
    Route::get('findmissingitem','API\MissingItemController@search');
    Route::get('findExpenses','API\ExpensesController@search');
    Route::get('findSales','API\SalesController@search');
    Route::get('findProduct','API\ProductController@search');
    Route::get('findSaleDetail','API\SalesDetailsController@search');
    Route::get('storesalesdetails','API\SalesDetailsController@persist');
    Route::post('filtersalesdetails','API\SalesDetailsController@dateFilter');
    Route::post('filtersales','API\SalesController@dateFilter');
    Route::post('filterexpenses','API\ExpensesController@dateFilter');
    Route::post('persistproduct','API\ProductController@persist');
    Route::get('invoice', function () {
        return view('invoice');
    });
});


Route::get('/', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where('path','([A-z\d-\/_.]+)?');
