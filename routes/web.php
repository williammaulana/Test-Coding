<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/convert', 'App\Http\Controllers\ConvertController@convert');
Route::post('/create_ordered', 'App\Http\Controllers\ProductController@create_ordered');
Route::post('/create_current_stock', 'App\Http\Controllers\ProductController@create_current_stock');
Route::post('/update/{{model_number}}', 'App\Http\Controllers\ProductController@update');
Route::post('/delete/{{model_number}}', 'App\Http\Controllers\ProductController@delete');

Route::get('/inventory_list', 'App\Http\Controllers\ProductController@inventory_list');
Route::get('/order_list', 'App\Http\Controllers\ProductController@order_list');
