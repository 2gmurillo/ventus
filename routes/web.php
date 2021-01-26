<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', [
        App\Http\Controllers\HomeController::class, 'index'
    ])->name('home');

    Route::post('products/{product}/carts', [
        \App\Http\Controllers\ProductCartController::class, 'addProductToCart'
    ])->name('products.carts.addProductToCart');

    Route::resource('carts', \App\Http\Controllers\CartController::class)
        ->only('index');

    Route::match(['put', 'patch'], 'products/{product}/carts/{cart}', [
        \App\Http\Controllers\ProductCartController::class, 'removeProductFromCart'
    ])->name('products.carts.removeProductFromCart');

    Route::resource('orders', \App\Http\Controllers\OrderController::class)
        ->except('destroy');
});
