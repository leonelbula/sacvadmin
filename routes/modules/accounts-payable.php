<?php


use App\Http\Controllers\AccountsPayablePaymentController;
use App\Http\Controllers\AccountsPayableSupplierController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('accounts-payable')->name('accounts-payable.')
    ->controller(AccountsPayableSupplierController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
    });


Route::prefix('accounts-payable')->name('accounts-payable.')->middleware('auth')->group(function () {

    Route::get('/{id}/payments', [AccountsPayablePaymentController::class, 'index',])->name('payments.index');
    Route::get('/{id}/payments/create', [AccountsPayablePaymentController::class, 'create',])->name('payments.create');
    Route::post('/{id}/payments', [AccountsPayablePaymentController::class, 'store',])->name('payments.store');
    Route::get('/{id}/payments/{paymentId}/pdf', [AccountsPayablePaymentController::class, 'pdf'])->name('payments.pdf');
});
