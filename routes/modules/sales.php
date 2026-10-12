<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/sale', [SaleController::class, 'index'])->middleware('permission:sale.view')->name('sale.index');
Route::get('/sale/create', [SaleController::class, 'create'])->middleware('permission:sale.create')->name('sale.create');
Route::post('/sale/store', [SaleController::class, 'store'])->middleware('permission:sale.create')->name('sale.store');
Route::get('/sale/{sale}', [SaleController::class, 'show'])->middleware('permission:sale.view')->name('sale.show');
Route::get('/sale/{sale}/edit', [SaleController::class, 'edit'])->middleware('permission:sale.edit')->name('sale.edit');
Route::put('/sale/{sale}', [SaleController::class, 'update'])->middleware('permission:sale.edit')->name('sale.update');
Route::delete('/sale/{sale}', [SaleController::class, 'destroy'])->middleware('permission:sale.delete')->name('sale.destroy');

Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sale.print');
Route::get('sale/ticket/{sale}', [SaleController::class, 'ticket'])->name('sale.ticket');
Route::get('sale/ticket2/{sale}', [SaleController::class, 'ticketepson'])->name('sale.ticketepson');

Route::get('sales/search-sale/{saleNumber}', [SaleController::class, 'searchSale'])->name('search-sale');
