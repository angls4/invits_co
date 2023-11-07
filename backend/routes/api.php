<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\PackageController;
use App\Http\Controllers\ApiControllers\ThemeController;
use App\Http\Controllers\ApiControllers\OrderController;
use App\Http\Controllers\ApiControllers\WeddingController;
use App\Http\Controllers\ApiControllers\WishController;
use App\Http\Controllers\ApiControllers\RsvpController;
use App\Http\Controllers\ApiControllers\GuestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Package
|--------------------------------------------------------------------------
*/
Route::prefix('packages')->group(function () {
    Route::get('/', [PackageController::class, 'index']);
    Route::get('/{id}', [PackageController::class, 'show']);
    
    // Auth : Admin
    Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
        Route::post('/', [PackageController::class, 'store']);
        Route::put('/{id}', [PackageController::class, 'update']);
        Route::delete('/{id}', [PackageController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
*/
Route::prefix('themes')->group(function () {
    Route::get('/', [ThemeController::class, 'index']);
    Route::get('/{id}', [ThemeController::class, 'show']);
    
    // Auth : Admin
    Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
        Route::post('/', [ThemeController::class, 'store']);
        Route::post('/{id}', [ThemeController::class, 'update']);
        Route::delete('/{id}', [ThemeController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| Order
|--------------------------------------------------------------------------
*/
Route::prefix('orders')->group(function () {
    // Route::get('/', [OrderController::class, 'index']);
    // Route::post('/', [OrderController::class, 'store']);
    
    // Auth
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{id}', [OrderController::class, 'show']);
    });
    
    // Auth: Admin
    Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
        // Route::put('/{id}', [OrderController::class, 'update']);
        // Route::delete('/{id}', [OrderController::class, 'destroy']);
    });
});

Route::prefix('orders-user')->group(function () {
    // Auth: User
    Route::middleware(['auth:sanctum', 'isUser'])->group(function () {
        Route::get('/{user_id}', [OrderController::class, 'getByUserID']);
    });
});

/*
|--------------------------------------------------------------------------
| Midtrans
|--------------------------------------------------------------------------
*/
Route::post('/midtrans-callback',  [OrderController::class, 'makeOrderMidtransCallback'])->name('midtransCallback');

/*
|--------------------------------------------------------------------------
| Wedding
|--------------------------------------------------------------------------
*/
Route::prefix('weddings')->group(function () {
    // Route::get('/', [WeddingController::class, 'index']);
    // Route::post('/', [WeddingController::class, 'store']);

    // Auth: User
    Route::middleware(['auth:sanctum', 'isUser'])->group(function () {

    });
    
    // Auth: Admin
    Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
        // Route::put('/{id}', [WeddingController::class, 'update']);
        // Route::delete('/{id}', [WeddingController::class, 'destroy']);
    });
});

Route::prefix('weddings-order')->group(function () {
    // Auth: User
    Route::middleware(['auth:sanctum', 'isUser'])->group(function () {
        Route::get('/{order_id}', [WeddingController::class, 'get_by_order_id']);
        Route::post('/{order_id}', [WeddingController::class, 'update_by_order_id']);
    });
});

Route::prefix('weddings-invitation')->group(function () {
    Route::get('/{slug}', [WeddingController::class, 'get_invitation_by_slug']);
});

/*
|--------------------------------------------------------------------------
| Wish
|--------------------------------------------------------------------------
*/
Route::prefix('wishes')->group(function () {
    Route::post('/', [WishController::class, 'store']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{id}', [WishController::class, 'show']);
        Route::delete('/{id}', [WishController::class, 'destroy']);
    });
});

Route::prefix('wishes-wedding')->group(function () {
    // Auth: User
    Route::middleware(['auth:sanctum', 'isUser'])->group(function () {
        Route::get('/{wedding_id}', [WishController::class, 'get_by_wedding_id']);
    });
});


/*
|--------------------------------------------------------------------------
| Rsvp
|--------------------------------------------------------------------------
*/
Route::prefix('rsvps')->group(function () {
    Route::post('/', [RsvpController::class, 'store']);

    // Auth
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{id}', [RsvpController::class, 'show']);
        Route::delete('/{id}', [RsvpController::class, 'destroy']);
    });
});

Route::prefix('rsvps-invitation')->group(function () {
    // Auth: User
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{invitation_id}', [RsvpController::class, 'get_by_invitation_id']);
    });
});

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::prefix('guests')->group(function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/', [GuestController::class, 'store']);

    // Auth
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{id}', [GuestController::class, 'show']);
        Route::put('/{id}', [GuestController::class, 'update']);
        Route::delete('/{id}', [GuestController::class, 'destroy']);
    });
});

Route::prefix('guests-invitation')->group(function () {
    // Auth: User
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/{invitation_id}', [GuestController::class, 'get_by_invitation_id']);
    });
});


/*
|--------------------------------------------------------------------------
| Example
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('admin/dashboard', 'AdminController@dashboard');
});

