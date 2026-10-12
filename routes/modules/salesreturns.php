<?php

use App\Http\Controllers\SaleReturnController;
use Illuminate\Support\Facades\Route;


Route::get('/salereturn', [SaleReturnController::class, 'index'])->middleware('permission:salereturn.view')->name('salereturn.index');
Route::get('/salereturn/create', [SaleReturnController::class, 'create'])->middleware('permission:salereturn.create')->name('salereturn.create');
Route::post('/salereturn', [SaleReturnController::class, 'store'])->middleware('permission:salereturn.create')->name('salereturn.store');
Route::get('/salereturn/{saleReturn}', [SaleReturnController::class, 'show'])->middleware('permission:salereturn.view')->name('salereturn.show');
Route::get('/salereturn/{saleReturn}/edit', [SaleReturnController::class, 'edit'])->middleware('permission:salereturn.edit')->name('salereturn.edit');
Route::put('/salereturn/{saleReturn}', [SaleReturnController::class, 'update'])->middleware('permission:salereturn.edit')->name('salereturn.update');
Route::delete('/salereturn/{saleReturn}', [SaleReturnController::class, 'destroy'])->middleware('permission:salereturn.delete')->name('salereturn.destroy');

Route::get('salereturn/ticket/{salereturn}', [SaleReturnController::class, 'ticket'])->name('salereturn.ticket');

