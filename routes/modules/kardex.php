<?php

use App\Http\Controllers\KardexController;
use Illuminate\Support\Facades\Route;



Route::get('/kardex/index/{search?}', [KardexController::class, 'index'])->middleware('permission:kardex.view')->name('kardex.index');
Route::get('/kardex/show/{id}', [KardexController::class, 'show'])->middleware('permission:kardex.view')->name('kardex.show');
Route::get('kardex/showdetail/{id}', [KardexController::class, 'showDetail'])->middleware('permission:kardex.view')->name('kardex.showDetail');
