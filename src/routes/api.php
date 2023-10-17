<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
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

Route::prefix('v1')->group(function () {

    Route::post('/auth/login', LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/auth/logout', LogoutController::class);

        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
        Route::get('/users/{id}/',[UserController::class,'show']);
        Route::put('/users/{id}',[UserController::class,'update']);
        Route::delete('/users/{id}/',[UserController::class,'destroy']);

        Route::get('/customers',[CustomerController::class,'index']);
        Route::post('/customers',[CustomerController::class,'store']);
        Route::get('/customers/{id}/',[CustomerController::class,'show']);
        Route::put('/customers/{id}',[CustomerController::class,'update']);
        Route::delete('/customers/{id}/',[CustomerController::class,'destroy']);

        Route::get('/products',[ProductController::class,'index']);
        Route::post('/products',[ProductController::class,'store']);
        Route::get('/products/{id}/',[ProductController::class,'show']);
        Route::put('/products/{id}',[ProductController::class,'update']);
        Route::delete('/products/{id}/',[ProductController::class,'destroy']);

        Route::get('/orders',[OrderController::class,'index']);
        Route::post('/orders',[OrderController::class,'store']);
        Route::get('/orders/{id}/discounts',[OrderController::class,'discounts']);
        Route::get('/orders/{id}',[OrderController::class,'update']);
        Route::put('/orders/{id}',[OrderController::class,'update']);
        Route::delete('/orders/{id}/',[OrderController::class,'destroy']);


    });
});
