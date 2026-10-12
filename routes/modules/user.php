<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:user.view'])->get('/user', [UserController::class, 'index'])->name('user.index');
Route::middleware(['auth', 'permission:user.create'])->get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::middleware(['auth', 'permission:user.create'])->post('/user', [UserController::class, 'store'])->name('user.store');
Route::middleware(['auth', 'permission:user.view'])->get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::middleware(['auth', 'permission:user.edit'])->get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::middleware(['auth', 'permission:user.edit'])->put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::middleware(['auth', 'permission:user.delete'])->delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
