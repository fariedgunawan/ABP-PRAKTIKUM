<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\CustomerApiController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\ProfileApiController;
use App\Http\Controllers\API\TransactionApiController;

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


Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Category API
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::post('/categories', [CategoryApiController::class, 'store']);
    Route::get('/categories/{id}', [CategoryApiController::class, 'show']);
    Route::put('/categories/{id}', [CategoryApiController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']);

    // Customer API
    Route::get('/customers', [CustomerApiController::class, 'index']);
    Route::post('/customers', [CustomerApiController::class, 'store']);
    Route::get('/customers/{id}', [CustomerApiController::class, 'show']);
    Route::put('/customers/{id}', [CustomerApiController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerApiController::class, 'destroy']);

    // Product API
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);

    // Profile
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
    Route::delete('/profile', [ProfileApiController::class, 'destroy']);

    // Transaction
    Route::get('/transactions', [TransactionApiController::class, 'index']);
    Route::post('/transactions', [TransactionApiController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionApiController::class, 'show']);
    Route::put('/transactions/{id}', [TransactionApiController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionApiController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);