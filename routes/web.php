<?php

use App\Http\Controllers\TypeExpenseController;
use App\Http\Controllers\AccountStatusCustomerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductReports;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalePaymentController;
use Illuminate\Support\Facades\Route;


//nuevas rutas


Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware('auth')->group(function () {
    Route::resource('accountstatecustomer', AccountStatusCustomerController::class);
    Route::resource('salepyment', SalePaymentController::class);
});

Route::middleware('auth')->group(function () {
    require __DIR__ . '/modules/categories.php';
    require __DIR__ . '/modules/products.php';
    require __DIR__ . '/modules/customers.php';
    require __DIR__ . '/modules/suppliers.php';
    require __DIR__ . '/modules/shopping.php';
    require __DIR__ . '/modules/sales.php';
    require __DIR__ . '/modules/salesreturns.php';
    require __DIR__ . '/modules/expenses.php';
    require __DIR__ . '/modules/reports.php';
    require __DIR__ . '/modules/roles.php';
    require __DIR__ . '/modules/kardex.php';
    require __DIR__ . '/modules/configuration.php';
    require __DIR__ . '/modules/pos.php';
    require __DIR__ . '/modules/user.php';
    require __DIR__ . '/modules/accounts-receivable.php';
    require __DIR__ . '/modules/accounts-payable.php';
    require __DIR__ . '/modules/inventory-asjustement.php';


    Route::middleware('auth')
        ->prefix('configuration')
        ->name('configuration.')
        ->controller(ConfigurationController::class)
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:configuration.view')->name('index');
            Route::put('/', 'update')->name('update');
        });

    //**/ */


    Route::get('/accountcustomer/{sale}', [AccountStatusCustomerController::class, 'list_show'])->name('accountsattuscustomer.list_show');

    Route::get('/recibopago/{id}', [SalePaymentController::class, 'print'])->name('salepayment.print');




    Route::get('/expense-types/{typeExpense?}', [TypeExpenseController::class, 'index'])->name('expense-types.index');
    Route::post('/expense-types/typeExpense', [TypeExpenseController::class, 'store'])->name('expense-types.store');
    Route::put('/expense-types/{id}', [TypeExpenseController::class, 'update'])->name('expense-types.update');
    Route::delete('/expense-types/{id}', [TypeExpenseController::class, 'update'])->name('expense-types.destroy');
});

Route::middleware(['auth'])->prefix('inventario/reportes')->name('inventory.reports.')->group(function () {

    Route::get('/', [ProductReports::class, 'index'])->name('index');
    Route::get('/stock-general', [ProductReports::class, 'stockGeneral'])
        ->name('stock');

    Route::get('/pdfstockgeneral', [ProductReports::class, 'downloadPdfStock'])
        ->name('downloadPdfStock');

    Route::get('/bajo-stock', [ProductReports::class, 'lowStock'])
        ->name('low_stock');

    Route::get('/pdfstockbajo', [ProductReports::class, 'downloadlowStock'])
        ->name('downloadPdflowStock');

    Route::get('/kardex', [ProductReports::class, 'kardex'])
        ->name('kardex');

    Route::get('/por-categoria', [ProductReports::class, 'byCategory'])
        ->name('category');

    Route::get('/por-proveedor', [ProductReports::class, 'bySupplier'])
        ->name('supplier');

    Route::get('/valorizacion', [ProductReports::class, 'valuation'])
        ->name('valuation');

    Route::get('/vencidos', [ProductReports::class, 'expired'])
        ->name('expired');

    Route::get('/historial', [ProductReports::class, 'history'])
        ->name('history');
});








require __DIR__ . '/auth.php';
