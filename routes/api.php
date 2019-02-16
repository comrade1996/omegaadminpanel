<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['user'=>'API\UserController']);
Route::apiResources(['category'=>'API\CategoryController']);
Route::apiResources(['expensescategory'=>'API\ExpensesCategoryController']);
Route::apiResources(['expenses'=>'API\ExpensesController']);
Route::apiResources(['sales'=>'API\SalesController']);
Route::apiResources(['product'=>'API\ProductController']);
Route::get('findUser','API\UserController@search');
Route::get('findCategory','API\CategoryController@search');
Route::get('findExpensesCategory','API\ExpensesCategoryController@search');
Route::get('findExpenses','API\ExpensesController@search');
Route::get('findSales','API\SalesController@search');
Route::get('findProduct','API\ProductController@search');