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

// Admin auth routes
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login.form');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login');


Route::get('/', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where('path','([A-z\d-\/_.]+)?');

