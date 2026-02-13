<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RepairController;

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::post('/', [ClientController::class, 'store']);
    Route::get('/{id}', [ClientController::class, 'show']);
    Route::put('/{id}', [ClientController::class, 'update']);
    Route::delete('/{id}', [ClientController::class, 'destroy']);
});

Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::post('/', [VehicleController::class, 'store']);
    Route::get('/{id}', [VehicleController::class, 'show']);
    Route::put('/{id}', [VehicleController::class, 'update']);
    Route::delete('/{id}', [VehicleController::class, 'destroy']);
});

Route::prefix('repairs')->group(function () {
    Route::get('/', [RepairController::class, 'index']);
    Route::post('/', [RepairController::class, 'store']);
    Route::get('/{id}', [RepairController::class, 'show']);
    Route::put('/{id}', [RepairController::class, 'update']);
    Route::delete('/{id}', [RepairController::class, 'destroy']);
});