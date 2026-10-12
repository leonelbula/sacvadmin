<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

 Route::get('/role', [RoleController::class, 'index'])->middleware('permission:role.view')->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->middleware('permission:role.create')->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->middleware('permission:role.create')->name('role.store');
    Route::get('/role/{role}', [RoleController::class, 'show'])->middleware('permission:role.view')->name('role.show');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:role.edit')->name('role.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->middleware('permission:role.edit')->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->middleware('permission:role.delete')->name('role.destroy');