<?php

namespace App\Http\Controllers\Api;

use App\Http\Middleware\IsAdminApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function() {
    
    Route::middleware(IsAdminApi::class)->prefix('admin')->group(function(){
        
        Route::get('category/list',[Admin\CategoryController::class,'list']);
        Route::resource('category',Admin\CategoryController::class);
        Route::resource('product',Admin\ProductController::class);
        Route::resource('transaction',Admin\TransactionController::class);

    });
    
});
