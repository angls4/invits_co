<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');

Route::prefix('order')->name('order.')->group(function () {
    // Route::view('/', 'user/order/index')->name('index');
    Route::get('/',  [OrderController::class, 'makeOrderSelectPackage'])->name('index');
    Route::get('/theme/{package_id}',  [OrderController::class, 'makeOrderSelectTheme'])->name('theme');
    Route::get('/summary/{theme_id}',  [OrderController::class, 'makeOrderSummary'])->name('summary');
    Route::get('/checkout/{theme_id}',  [OrderController::class, 'makeOrder'])->name('checkout');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])
                ->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])
                    ->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::middleware('check.token')->group(function (){
    Route::post('logout', [LoginController::class, 'destroy'])
                    ->name('logout');
});