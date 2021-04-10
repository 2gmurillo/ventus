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

    Route::resource('equipments', \App\Http\Controllers\EquipmentController::class);

    Route::match(['put', 'patch'], 'products/{product}/carts/{cart}', [
        \App\Http\Controllers\ProductCartController::class, 'removeProductFromCart'
    ])->name('products.carts.removeProductFromCart');

    Route::resource('orders', \App\Http\Controllers\OrderController::class)
        ->except('destroy');

    Route::post('products/carts/orders/{order}', [
        \App\Http\Controllers\ProductCartOrderController::class, 'storeCartOrder'
    ])->name('products.carts.orders.storeCartOrder');
    Route::post('products/{product}/orders', [
        \App\Http\Controllers\ProductCartOrderController::class, 'addOne'
    ])->name('products.carts.orders.addOne');
    Route::match(['put', 'patch'], 'products/{product}/orders/{cartOrder}', [
        \App\Http\Controllers\ProductCartOrderController::class, 'removeOne'
    ])->name('products.carts.orders.removeOne');
    Route::delete('products/{product}/orders/{cartOrder}', [
        \App\Http\Controllers\ProductCartOrderController::class, 'destroy'
    ])->name('products.carts.orders.destroy');
});
