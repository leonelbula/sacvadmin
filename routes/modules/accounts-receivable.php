<?php

use App\Http\Controllers\AccountReceivablePaymentController;
use App\Http\Controllers\AccountsReceivableController;
use Illuminate\Support\Facades\Route;

 Route::middleware(['auth'])->prefix('accounts-receivable')->name('accounts-receivable.')
        ->controller(AccountsReceivableController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });

    Route::prefix('accounts-receivable')->name('accounts-receivable.')->middleware('auth')->group(function () {

        Route::get('/{id}/payments', [AccountReceivablePaymentController::class, 'index',])->name('payments.index');
        Route::get('/{id}/payments/create', [AccountReceivablePaymentController::class, 'create',])->name('payments.create');
        Route::post('/{id}/payments', [AccountReceivablePaymentController::class, 'store',])->name('payments.store');
        Route::get('/{id}/payments/{paymentId}/pdf', [AccountReceivablePaymentController::class, 'pdf'])->name('payments.pdf');
    });