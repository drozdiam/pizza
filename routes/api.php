<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login',[UserController::class,'login']);

    Route::middleware('api')->group(function () {
        Route::get('refresh', [UserController::class, 'refresh']);
        Route::get('logout', [UserController::class, 'logout']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('admin',[AdminController::class,'index']);
    });

    Route::middleware('role:user')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });

});
