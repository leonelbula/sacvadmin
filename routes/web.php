<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnSaleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified', 'company'])->name('dashboard');
Route::get('/companycreate', [HomeController::class, 'companycreate'])->middleware(['auth', 'verified'])->name('createcompany');
Route::post('/homecompanydata', [HomeController::class, 'store'])->middleware('auth')->name('homecompanydata.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'company')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('companydata', CompanyController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('shopping', ShoppingController::class);
    Route::resource('sale', SaleController::class);
    Route::resource('returnsale',ReturnSaleController::class);

});

Route::middleware('auth', 'company')->group(function () {
    Route::get('sale/factura/{sale}', [SaleController::class, 'invocesPdf'])->name('sale.invocesPdf');
    Route::get('sale/ticket/{sale}', [SaleController::class, 'ticket'])->name('sale.ticket');
     Route::get('returnsale/ticket/{returnsale}', [ReturnSaleController::class, 'ticket'])->name('returnsale.ticket');
});


Route::get('/customers/search/{q}', [CustomerController::class, 'search']);
Route::get('/products/search/{q}', [ProductController::class, 'search']);




require __DIR__ . '/auth.php';
