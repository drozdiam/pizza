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

    Route::middleware('auth:api')->group(function () {
        Route::resource('product',ProductController::class)->except([
            'edit', 'create'
        ]);
        Route::resource('user',UserController::class)->except([
            'edit', 'create'
        ]);

        Route::post('product/{productId}/images', [ImageController::class, 'store']);
        Route::delete('product/{productId}/image/{imageId}', [ImageController::class, 'destroy']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('admin',[AdminController::class,'index']);
    });

    Route::middleware('role:user')->group(function () {
//        Route::get('user', function (Request $request) {
//            return $request->user();
//        });
    });

});
