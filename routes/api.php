<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AttributesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'show']);

Route::apiResource('attributes', AttributesController::class);



Route::post('products/{product}/attributes', [AttributesController::class, 'attachToProduct']);
Route::put('products/{product}/attributes/{attribute}', [AttributesController::class, 'updateProductAttribute']);
Route::delete('products/{product}/attributes/{attribute}', [AttributesController::class, 'detachFromProduct']);


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('cart')->group(function () {
        Route::post('add', [CartController::class, 'add']);
        Route::post('remove', [CartController::class, 'remove']);
        Route::post('update', [CartController::class, 'update']);
    });
    Route::prefix('orders')->group(function () {
       Route::post('create', [OrderController::class, 'placeOrder']);
       Route::get('user', [OrderController::class, 'userOrders']);
    });
});
