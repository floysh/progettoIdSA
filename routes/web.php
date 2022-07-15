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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Products
Route::get('/products', 'ProductController@index');
Route::get('/products/create', 'ProductController@create'); //mostra il form per la creazione
Route::post('/products/create', 'ProductController@store'); //gestisce i dati inviati col form
Route::get('/products/{product}', 'ProductController@show')->name('ShowProduct');
Route::get('/products/{product}/edit', 'ProductController@edit')->name('EditProduct');
Route::patch('/products/{product}', 'ProductController@update');
Route::delete('/products/{product}', 'ProductController@destroy');
