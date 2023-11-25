<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\SendInvitation;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;

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
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])->name('social.login.callback');
});

Route::middleware('check.token')->group(function (){
    Route::post('logout', [LoginController::class, 'destroy'])
                    ->name('logout');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name(('ordersDetail'));
    
    Route::middleware('role:user')->prefix('client')->name('client.')->group(function () {
        // Client Order
        Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders');

        // Client Invitation
        Route::name('invitation.')->group(function(){
            Route::get('/invitations/{id}', [InvitationController::class, 'edit'])->name(('edit'));
            Route::post('/save/invitations/{id}', [InvitationController::class, 'update'])->name(('save'));
    
            // // Client Guest
            Route::name('guest.')->group(function(){
                Route::get('/invitations/{id}/guests/add', [GuestController::class, 'create'])->name('add');
                Route::post('/invitations/{id}/guests/save', [GuestController::class, 'store'])->name('save');
                Route::get('/invitations/{id}/guests/edit', [GuestController::class, 'edit'])->name('edit');
                Route::post('/invitations/{id}/guests/update', [GuestController::class, 'update'])->name('update');
                Route::get('/invitations/{id}/guests', [GuestController::class, 'index'])->name('index');
                Route::get('/invitations/{id}/guests/delete', [GuestController::class, 'destroy'])->name('delete');
                Route::post('/sendInvitation/{id}', [SendInvitation::class, 'sendInvitation'])->name('sendInvitation');
            });
            
            // Client RSVP
            Route::get('/invitations/{id}/rsvps', [RsvpController::class, 'index'])->name('rsvp');
        });

        // // Client Profile
        Route::name('profile.')->group(function(){
            Route::get('/{id}', [UserController::class, 'show'])->name('index');
            Route::post('/{id}', [UserController::class, 'update'])->name('update');
            Route::name('password.')->group(function(){
                Route::get('/{id}/changePassword', [PasswordController::class, 'edit'])->name('edit');
                Route::post('/{id}/changePassword', [PasswordController::class, 'update'])->name('update');
            });
        });
    });

    Route::middleware('role:admin')->prefix('dashboard')->name('admin.')->group(function () {
        Route::get('/', [PageController::class, 'dashboardIndex'])->name('index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    });
});

// invitation
Route::get('/{slug}', [InvitationController::class, 'show'])->name(('showInvitation'));
Route::post('/rsvp', [RsvpController::class, 'store'])->name(('rsvp'));
Route::post('/wishes', [WishController::class, 'store'])->name(('sendWish'));