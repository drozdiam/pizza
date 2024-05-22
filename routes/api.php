<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::resource('products',ProductController::class)->only('index');

    Route::middleware('auth:api')->group(function () {

    });

    Route::middleware('role:user')->group(function () {

    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('product',ProductController::class)->except([
            'edit', 'create', 'index'
        ]);
        Route::post('product/{productId}/images', [ImageController::class, 'store']);
        Route::delete('product/{productId}/image/{imageId}', [ImageController::class, 'destroy']);

        Route::resource('users',UserController::class)->except([
            'edit', 'create',
        ]);

    });

});
