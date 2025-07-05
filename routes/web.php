<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified','company'])->name('dashboard');
Route::get('/companycreate',[HomeController::class, 'companycreate'])->middleware(['auth', 'verified'])->name('createcompany');
Route::post('/homecompanydata',[HomeController::class, 'store'])->middleware('auth')->name('homecompanydata.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware('auth','company')->group(function(){
 Route::resource('category',CategoryController::class);
 Route::resource('product',ProductController::class);
 Route::resource('companydata', CompanyController::class);


});


require __DIR__.'/auth.php';
