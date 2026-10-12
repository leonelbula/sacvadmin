<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/customer', [CustomerController::class, 'index'])->middleware('permission:customer.view')->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->middleware('permission:customer.create')->name('customer.create');
Route::post('/customer', [CustomerController::class, 'store'])->middleware('permission:customer.create')->name('customer.store');
Route::get('/customer/{customer}', [CustomerController::class, 'show'])->middleware('permission:customer.view')->name('customer.show');
Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->middleware('permission:customer.edit')->name('customer.edit');
Route::put('/customer/{customer}', [CustomerController::class, 'update'])->middleware('permission:customer.edit')->name('customer.update');
Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->middleware('permission:customer.delete')->name('customer.destroy');


Route::get('/customers/search/{q}', [CustomerController::class, 'search']);
