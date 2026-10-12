<?php

use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Route;


Route::get('/shopping', [ShoppingController::class, 'index'])->middleware('permission:shopping.view')->name('shopping.index');
Route::get('/shopping/create', [ShoppingController::class, 'create'])->middleware('permission:shopping.create')->name('shopping.create');
Route::post('/shopping/store', [ShoppingController::class, 'store'])->middleware('permission:shopping.create')->name('shopping.store');
Route::get('/shopping/{shopping}', [ShoppingController::class, 'show'])->middleware('permission:shopping.view')->name('shopping.show');
Route::get('/shopping/{shopping}/edit', [ShoppingController::class, 'edit'])->middleware('permission:shopping.edit')->name('shopping.edit');
Route::put('/shopping/{shopping}', [ShoppingController::class, 'update'])->middleware('permission:shopping.edit')->name('shopping.update');
Route::delete('/shopping/{shopping}', [ShoppingController::class, 'destroy'])->middleware('permission:shopping.delete')->name('shopping.destroy');
