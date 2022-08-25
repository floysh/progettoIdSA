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

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::redirect('/home', '/', 301);

// Pagine negozio
Route::get('/search', 'StoreController@search');
Route::get('/products/category/{category}', 'StoreController@category');

// Products
Route::get('/products', 'ProductController@index');
Route::get('/products/create', 'ProductController@create');
Route::post('/products/create', 'ProductController@store');
Route::get('/products/{product}', 'ProductController@show');
Route::get('/products/{product}/edit', 'ProductController@edit');
Route::patch('/products/{product}', 'ProductController@update');
Route::delete('/products/{product}', 'ProductController@destroy');

// Cart
Route::get('/cart', 'CartController@index')->middleware('auth')->name('CartPage');
Route::post('/cart', 'CartController@store')->middleware('auth');
Route::delete('/cart/{cart}', 'CartController@destroy')->middleware('auth');
Route::patch('/cart/{cart}', 'CartController@update')->middleware('auth');

// Orders
Route::get('/orders', 'OrderController@index')->middleware('auth');
Route::post('/orders', 'OrderController@store')->middleware('auth');
Route::get('/orders/{order}', 'OrderController@show')->middleware('auth');
