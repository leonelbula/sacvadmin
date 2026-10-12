<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;



Route::get('/expense', [ExpenseController::class, 'index'])->middleware('permission:expense.view')->name('expense.index');
Route::get('/expense/create', [ExpenseController::class, 'create'])->middleware('permission:expense.create')->name('expense.create');
Route::post('/expense', [ExpenseController::class, 'store'])->middleware('permission:expense.create')->name('expense.store');
Route::get('/expense/{expence}', [ExpenseController::class, 'show'])->middleware('permission:expense.view')->name('expense.show');
Route::get('/expense/{expence}/edit', [ExpenseController::class, 'edit'])->middleware('permission:expense.edit')->name('expense.edit');
Route::put('/expense/{expence}', [ExpenseController::class, 'update'])->middleware('permission:expense.edit')->name('expense.update');
Route::delete('/expense/{expence}', [ExpenseController::class, 'destroy'])->middleware('permission:expense.delete')->name('expense.destroy');
