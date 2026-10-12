<?php

use App\Http\Controllers\InventoryAdjustmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('inventory/adjustments')->name('inventory.adjustments.')->group(function () {

    Route::get('/', [InventoryAdjustmentController::class, 'index'])->middleware('permission:inventory-adjustment.view')->name('index');
    Route::get('/create', [InventoryAdjustmentController::class, 'create'])->middleware('permission:inventory-adjustment.create')->name('create');
    Route::post('/', [InventoryAdjustmentController::class, 'store'])->middleware('permission:inventory-adjustment.create')->name('store');
    Route::get('/{id}', [InventoryAdjustmentController::class, 'show'])->middleware('permission:inventory-adjustment.view')->name('show');
});
