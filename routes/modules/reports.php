<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;


Route::get('/report', [ReportController::class, 'index'])->middleware('permission:report.view')->name('report.index');
Route::get('/report/sales', [ReportController::class, 'sales'])->middleware('permission:report.sales')->name('report.sales');
Route::get('/report/shopping', [ReportController::class, 'shopping'])->middleware('permission:report.shopping')->name('report.shopping');
Route::get('/report/expenses', [ReportController::class, 'expenses'])->middleware('permission:report.expenses')->name('report.expenses');
Route::get('/report/inventory', [ReportController::class, 'inventory'])->middleware('permission:report.inventory')->name('report.inventory');
Route::get('/report/kardex', [ReportController::class, 'kardex'])->middleware('permission:report.kardex')->name('report.kardex');
Route::get('/reporteinventario', [ReportController::class, 'reporteinventario'])->name('report.reporteinventario');



Route::prefix('reports')->name('reports.')->controller(ReportController::class)->group(function () {
    /* |--------------------------------------------------------------------------
        | DASHBOARD |
        -------------------------------------------------------------------------- */
    Route::get('/', 'index')->name('index');
    Route::get('/kardex', [ReportController::class, 'kardex'])->name('kardex');
    /* |--------------------------------------------------------------------------
        | VENTAS |
        -------------------------------------------------------------------------- */
    Route::get('/sales', 'sales')->name('sales');
    Route::get('/sales/products', 'salesProducts')->name('sales.products');
    Route::get('/sales/payment-methods', 'salesPaymentMethods')->name('sales.payment-methods');
    Route::get('/sales/customers', 'salesCustomers')->name('sales.customers');
    Route::get('/sales/products-by-category', 'getProductsByCategory')->name('sales.products-by-category');
    /* |--------------------------------------------------------------------------
        | INVENTARIO |
        -------------------------------------------------------------------------- */
    Route::get('/inventory', 'inventory')->name('inventory');
    Route::get('/inventory/valuation', 'inventoryValuation')->name('inventory.valuation');
    Route::get('/inventory/low-stock', 'inventoryLowStock')->name('inventory.low-stock');
    Route::get('/inventory/kardex', 'inventoryKardex')->name('inventory.kardex');
    /* |--------------------------------------------------------------------------
         | COMPRAS |
         -------------------------------------------------------------------------- */
    Route::get('/purchases', 'purchases')->name('purchases');
    Route::get('/purchases/products', 'purchasesProducts')->name('purchases.products');
    Route::get('/purchases/suppliers', 'purchasesSuppliers')->name('purchases.suppliers');
    /* |--------------------------------------------------------------------------
         | GASTOS |
         -------------------------------------------------------------------------- */
    Route::get('/expenses', 'expenses')->name('expenses');
    Route::get('/expenses/types', 'expensesTypes')->name('expenses.types');
    Route::get('/expenses/payment-methods', 'expensesPaymentMethods')->name('expenses.payment-methods');
    /* |--------------------------------------------------------------------------
        | FINANCIERO
        |-------------------------------------------------------------------------- */
    Route::get('/profit', 'profit')->name('financial.profit');
    Route::get('/cash-flow', 'cashFlow')->name('financial.cash-flow');
    Route::get('/payment-methods', 'paymentMethods')->name('financial.payment-methods');
    /* |--------------------------------------------------------------------------
         | CLIENTES |
         -------------------------------------------------------------------------- */
    Route::get('/customers', 'customers')->name('customers');
    Route::get('/customers/top', 'customersTop')->name('customers.top');
    Route::get('/customers/inactive', 'customersInactive')->name('customers.inactive');

    /*
|--------------------------------------------------------------------------
| PDF - VENTAS
|--------------------------------------------------------------------------
*/

    Route::get('/sales/pdf', 'salesPdf')->name('sales.pdf');
    Route::get('/sales/products/pdf', 'salesProductsPdf')->name('sales.products.pdf');
    Route::get('/sales/payment-methods/pdf', 'salesPaymentMethodsPdf')->name('sales.payment-methods.pdf');
    Route::get('/sales/customers/pdf', 'salesCustomersPdf')->name('sales.customers.pdf');
    Route::get('/sales/products-by-category/pdf', 'getProductsByCategoryPdf')->name('sales.products-by-category.pdf');


    /*
|--------------------------------------------------------------------------
| PDF - INVENTARIO
|--------------------------------------------------------------------------
*/

    Route::get('/inventory/pdf', 'inventoryPdf')->name('inventory.pdf');
    Route::get('/inventory/valuation/pdf', 'inventoryValuationPdf')->name('inventory.valuation.pdf');
    Route::get('/inventory/low-stock/pdf', 'inventoryLowStockPdf')->name('inventory.low-stock.pdf');
    Route::get('/inventory/kardex/pdf', 'kardexPdf')->name('inventory.kardex.pdf');


    /*
|--------------------------------------------------------------------------
| PDF - COMPRAS
|--------------------------------------------------------------------------
*/

    Route::get('/purchases/pdf', 'purchasesPdf')->name('purchases.pdf');
    Route::get('/purchases/products/pdf', 'purchasesProductsPdf')->name('purchases.products.pdf');
    Route::get('/purchases/suppliers/pdf', 'purchasesSuppliersPdf')->name('purchases.suppliers.pdf');


    /*
|--------------------------------------------------------------------------
| PDF - GASTOS
|--------------------------------------------------------------------------
*/

    Route::get('/expenses/pdf', 'expensesPdf')->name('expenses.pdf');
    Route::get('/expenses/types/pdf', 'expensesTypesPdf')->name('expenses.types.pdf');
    Route::get('/expenses/payment-methods/pdf', 'expensesPaymentMethodsPdf')->name('expenses.payment-method.pdf');


    /*
|--------------------------------------------------------------------------
| PDF - FINANCIERO
|--------------------------------------------------------------------------
*/

    Route::get('/profit/pdf', 'profitPdf')->name('financial.profit.pdf');
    Route::get('/cash-flow/pdf', 'cashFlowPdf')->name('financial.cash-flow.pdf');

    Route::get('/payment-methods/pdf', 'paymentMethodsPdf')->name('financial.payment-methods.pdf');


    /*
|--------------------------------------------------------------------------
| PDF - CLIENTES
|--------------------------------------------------------------------------
*/

    Route::get('/customers/pdf', 'customersPdf')->name('customers.customers.pdf');
    Route::get('/customers/top/pdf', 'topCustomersPdf')->name('customers.customers-top.pdf');
    Route::get('/customers/inactive/pdf', 'inactiveCustomersPdf')->name('customers.customers-inactive.pdf');
});
