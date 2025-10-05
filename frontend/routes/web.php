<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\IllustratorMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::controller(AuthController::class)->group(function () {
    Route::get('/register/customer', 'showRegisterCustomer')->name('register.customer');
    Route::post('/register/customer', 'registerCustomer')->name('register.customer');
    Route::get('/register/illustrator', 'showRegisterIllustrator')->name('register.illustrator');
    Route::post('/register/illustrator', 'registerIllustrator')->name('register.illustrator');

    Route::get('/login/customer', 'showLoginCustomer')->name('login.customer');
    Route::post('/login/customer', 'loginCustomer')->name('login.customer');
    Route::get('/login/illustrator', 'showLoginIllustrator')->name('login.illustrator');
    Route::post('/login/illustrator', 'loginIllustrator')->name('login.illustrator');

    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/market', [MarketController::class, 'index'])->name('market');
Route::get('/filter', [MarketController::class, 'filter'])->name('filter');
Route::get('/illustration/{id}', [MarketController::class, 'showIllustration'])->name('showIllustration');
Route::get('/profile/{id}', [DashboardController::class, 'showProfile'])->name('showProfile');

Route::middleware([CustomerMiddleware::class])->group(function () {
    Route::get('/buy/{id}', [MarketController::class, 'showBuy'])->name('showBuy');
    Route::post('/buy', [MarketController::class, 'buy'])->name('buy');
    Route::get('/collections', [DashboardController::class, 'showCollections'])->name('collections');
    Route::get('/histories', [DashboardController::class, 'showHistories'])->name('histories');
});

Route::middleware([IllustratorMiddleware::class])->group(function () {
    Route::get('/sell', [MarketController::class, 'showSell'])->name('sell');
    Route::post('/sell', [MarketController::class, 'sell'])->name('sell');
    Route::get('/listings', [DashboardController::class, 'showListings'])->name('listings');
});


Route::controller(AdminController::class)->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::get('/auth', 'redirect')->name('redirect');
    Route::get('/auth/callback', 'callback')->name('callback');
    Route::get('/logout', 'logout')->name('logout');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/', 'showCustomers')->name('index');
        Route::get('/customers', 'showCustomers')->name('customers');
        Route::get('/illustrators', 'showIllustrators')->name('illustrators');
        Route::get('/user/{id}', 'deleteUser')->name('deleteUser');
        Route::get('/edit/customer/{id}', 'showEditCustomer')->name('showEditCustomer');
        Route::post('/edit/customers/{id}', 'editCustomer')->name('editCustomer');
        Route::get('/edit/illustrator/{id}', 'showEditIllustrator')->name('showEditIllustrator');
        Route::post('/edit/illustrators/{id}', 'editIllustrator')->name('editIllustrator');
        Route::get('/purchases', 'showPurchases')->name('purchases');
        Route::post('/purchases/{id}/verify', 'verifyPurchase')->name('verify');
        Route::post('/purchases/{id}/reject', 'rejectPurchase')->name('reject');
    });
});
