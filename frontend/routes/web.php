<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Auth\RegisterController;

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
    
    Route::prefix('client')->name('client.')->group(function () {
        // $controller_invitation = 'Modules\Invitation\Http\Controllers\Frontend\InvitationsController';
        // $controller_profile = 'App\Http\Controllers\ProfileController';
        // $controller_order = 'Modules\Order\Http\Controllers\Frontend\OrdersController';
        // $controller_guest = 'Modules\Invitation\Http\Controllers\Frontend\GuestController';
        // $controller_rsvp = 'Modules\Invitation\Http\Controllers\Frontend\RsvpController';
        
        // Client Order
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name(('ordersDetail'));
        // Route::view('/bills', 'user/order/detail')->name('bills');

        // Client Invitation
        Route::get('/invitations/{id}', [InvitationController::class, 'edit'])->name(('editInvitation'));
        Route::post('/save/invitations/{id}', [InvitationController::class, 'update'])->name(('save.editInvitation'));

        // // Client Guest
        // Route::match(['GET', 'POST'], '/invitations/{id}/guests/add', $controller_guest . '@addGuest')->name(('addGuest'));
        // Route::match(['GET', 'POST'], '/invitations/{id}/guests/edit', $controller_guest . '@editGuest')->name(('guest.edit'));
        // Route::get('/invitations/{id}/guests', $controller_guest . '@index')->name('guest.index');
        // Route::post('/sendInvitation/{id}', $controller_guest . '@sendInvitation')->name('guest.sendInvitation');
        // Route::get('guests/{id}', $controller_guest . '@deleteGuest')->name('guest.delete');

        // Client RSVP
        // Route::get('/invitations/{id}/rsvps', $controller_rsvp . '@index')->name('rsvp');

        // // Client Profile
        // Route::get('/{id}', $controller_profile  . '@show')->name('index');
        // Route::post('/{id}', $controller_profile . '@edit')->name('editProfile');
        // Route::get('/{id}/changePassword', $controller_profile  . '@editPassword')->name('editPassword');
        // Route::post('/{id}/changePassword', $controller_profile . '@updatePassword')->name('updatePassword');
    });
});

// invitation
Route::get('/{slug}', [InvitationController::class, 'show'])->name(('showInvitation'));
Route::post('/rsvp', [RsvpController::class, 'store'])->name(('rsvp'));
Route::post('/wishes', [WishController::class, 'store'])->name(('sendWish'));