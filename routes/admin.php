<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
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

Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
Route::match(['put', 'patch'], 'users/{user}/status', [UserController::class, 'changeUserStatus'])->name('users.status');
Route::resource('products', ProductController::class)->except(['show', 'create', 'edit']);

