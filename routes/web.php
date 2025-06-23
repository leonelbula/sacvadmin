<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function(){
   Route::get('/categoria', [CategoryController::class,'index'])->name('category.index');
   Route::get('/categoria/ver/{category}', [CategoryController::class,'show'])->name('category.show');
   Route::get('/categoria/editar/{category}', [CategoryController::class,'edit'])->name('category.edit');
   Route::get('/categoria/crear', [CategoryController::class,'create'])->name('category.create');
   Route::post('/categoria/guardar', [CategoryController::class,'store'])->name('category.store');
   Route::put('/categoria/{category}', [CategoryController::class,'update'])->name('category.update');
   Route::delete('/categoria/{category}', [CategoryController::class,'destroy'])->name('category.destroy');

});


require __DIR__.'/auth.php';
