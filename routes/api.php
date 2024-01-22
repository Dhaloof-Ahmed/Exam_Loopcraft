<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopProductController;
use App\Http\Controllers\ShopBrandController;
use App\Http\Controllers\ShopCustomerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // Shop Products Routes
    Route::get('/shop/products', [ShopProductController::class, 'index']);
    Route::get('/shop/products/{id}', [ShopProductController::class, 'show']);
    Route::post('/shop/products', [ShopProductController::class, 'store']);
    Route::put('/shop/products/{id}', [ShopProductController::class, 'update']);
    Route::delete('/shop/products/{id}', [ShopProductController::class, 'destroy']);

    // Shop Brands Routes
    Route::get('/shop/brands', [ShopBrandController::class, 'index']);
    Route::get('/shop/brands/{id}', [ShopBrandController::class, 'show']);
    Route::post('/shop/brands', [ShopBrandController::class, 'store']);
    Route::put('/shop/brands/{id}', [ShopBrandController::class, 'update']);
    Route::delete('/shop/brands/{id}', [ShopBrandController::class, 'destroy']);

    // Shop Customers Routes
    Route::get('/shop/customers', [ShopCustomerController::class, 'index']);
    Route::get('/shop/customers/{id}', [ShopCustomerController::class, 'show']);
    Route::post('/shop/customers', [ShopCustomerController::class, 'store']);
    Route::put('/shop/customers/{id}', [ShopCustomerController::class, 'update']);
    Route::delete('/shop/customers/{id}', [ShopCustomerController::class, 'destroy']);
});

// Additional route for customer restore and force delete
Route::middleware('auth:sanctum')->prefix('/shop/customers')->group(function () {
    Route::post('/{id}/restore', [ShopCustomerController::class, 'restore']);
    Route::delete('/{id}/force-delete', [ShopCustomerController::class, 'forceDelete']);
});
