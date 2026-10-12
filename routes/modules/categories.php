<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/category/{category?}', [CategoryController::class, 'index'])->middleware('permission:category.view')->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->middleware('permission:category.create')->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->middleware('permission:category.create')->name('category.store');
Route::get('/category/{category}', [CategoryController::class, 'show'])->middleware('permission:category.view')->name('category.show');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->middleware('permission:category.edit')->name('category.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('permission:category.edit')->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('permission:category.delete')->name('category.destroy');
