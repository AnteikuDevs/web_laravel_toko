<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\IsKasir;
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

Route::middleware(IsGuest::class)->group(function () {

    Route::get('/', [AuthController::class,'login'])->name('login');

});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(IsAdmin::class)->prefix('admin')->name('admin.')->group(function () {
    
    Route::redirect('admin','admin/dashboard',302)->name('admin.index');

    Route::resource('dashboard', Admin\DashboardController::class)->only('index');

    Route::resource('category', Admin\CategoryController::class);

    Route::resource('product', Admin\ProductController::class);

    Route::resource('transaction', Admin\TransactionController::class);
        
});

Route::middleware(IsKasir::class)->prefix('kasir')->name('kasir.')->group(function () {
    
    Route::redirect('kasir','kasir/dashboard',302)->name('kasir.index');

    Route::resource('dashboard', Kasir\DashboardController::class)->only('index');

    Route::resource('transaction', Kasir\TransactionController::class);
        
});
