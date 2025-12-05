<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StoreController;
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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('company-settings', [CompanySettingController::class, 'edit'])
        ->name('company-settings.edit');
    Route::put('company-settings', [CompanySettingController::class, 'update'])
        ->name('company-settings.update');

    Route::resource('categories', CategoryController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('stock-movements', StockMovementController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

    Route::middleware('role:SUPER_ADMIN')->group(function () {
        Route::resource('stores', StoreController::class);
    });

    Route::middleware('role:SUPER_ADMIN,ADMIN')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});

