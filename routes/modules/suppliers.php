<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/supplier', [SupplierController::class, 'index'])->middleware('permission:supplier.view')->name('supplier.index');
Route::get('/supplier/create', [SupplierController::class, 'create'])->middleware('permission:supplier.create')->name('supplier.create');
Route::post('/supplier', [SupplierController::class, 'store'])->middleware('permission:supplier.create')->name('supplier.store');
Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->middleware('permission:supplier.view')->name('supplier.show');
Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->middleware('permission:supplier.edit')->name('supplier.edit');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->middleware('permission:supplier.edit')->name('supplier.update');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->middleware('permission:supplier.delete')->name('supplier.destroy');

Route::get('/supplier/search/{query}', [SupplierController::class, 'search']);
