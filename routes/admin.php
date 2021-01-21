<?php

use App\Http\Controllers\Admin\PanelController;
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

Route::get('/', [PanelController::class, 'index'])->name('panel');

Route::resources([
    'users' => UserController::class,
]);
Route::match(['put', 'patch'], 'users/{user}/status', [UserController::class, 'changeUserStatus'])->name('users.status');

