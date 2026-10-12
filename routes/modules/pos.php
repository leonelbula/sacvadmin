<?php

use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;



Route::get('/pos', [PosController::class, 'index'])->middleware('permission:pos.view')->name('pos.index');
Route::get('/pos/create', [PosController::class, 'create'])->middleware('permission:pos.create')->name('pos.create');
Route::put('/pos/{pos}', [PosController::class, 'update'])->middleware('permission:pos.edit')->name('pos.update');
Route::post('/pos', [PosController::class, 'store'])->middleware('permission:pos.create')->name('pos.store');
Route::get('/pos/{pos}', [PosController::class, 'show'])->middleware('permission:pos.view')->name('pos.show');
Route::post('/pos/close', [PosController::class, 'close'])->middleware('permission:pos.close')->name('pos.close');
Route::get('previewposclose', [PosController::class, 'previewclose'])->middleware('permission:pos.edit')->name('pos.previewclose');
Route::get('/pos/{pos}/print', [PosController::class, 'print'])->middleware('permission:pos.edit')->name('pos.print');
