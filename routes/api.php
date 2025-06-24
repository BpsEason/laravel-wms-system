<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InboundOrderController;
use App\Http\Controllers\OutboundOrderController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Authentication routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // WMS API Routes
    Route::apiResource('products', ProductController::class);
    Route::apiResource('warehouses', WarehouseController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('inbound-orders', InboundOrderController::class);
    Route::post('inbound-orders/{id}/receive-items', [InboundOrderController::class, 'receiveItems']);
    Route::apiResource('outbound-orders', OutboundOrderController::class);
    Route::post('outbound-orders/{id}/pick-items', [OutboundOrderController::class, 'pickItems']);
    Route::post('outbound-orders/{id}/ship', [OutboundOrderController::class, 'shipOrder']);
});
