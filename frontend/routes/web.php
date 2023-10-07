<?php

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

Route::get('/', function () {
    return view('user.home.index', ['title' => 'Home']);
})->name('home');
Route::view('/login', 'auth.login', ['title' => 'Login'])->name('login');
Route::view('/register', 'auth.register', ['title' => 'register'])->name('register');
