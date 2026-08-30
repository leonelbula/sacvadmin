<?php

use App\Http\Controllers\AccountStatusCustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReports;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnSaleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KardexController;
use Illuminate\Support\Facades\Route;


//nuevas rutas


Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/companycreate', [HomeController::class, 'companycreate'])->middleware(['auth', 'verified'])->name('createcompany');
Route::post('/homecompanydata', [HomeController::class, 'store'])->middleware('auth')->name('homecompanydata.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('companydata', CompanyController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('shopping', ShoppingController::class);
    Route::resource('sale', SaleController::class);
    Route::resource('returnsale', ReturnSaleController::class);
    Route::resource('pos', PosController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('accountstatecustomer', AccountStatusCustomerController::class);
    Route::resource('salepyment', SalePaymentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('category/{category?}/{request?}', [CategoryController::class, 'index'])->name('category.index');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store');
    Route::put('category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/product/search/{query}', [ProductController::class, 'search'])->name('product.search');
    Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sale.print');
    Route::get('sale/ticket/{sale}', [SaleController::class, 'ticket'])->name('sale.ticket');
    Route::post('/sale/store', [SaleController::class, 'store']);
    Route::get('sale/ticket2/{sale}', [SaleController::class, 'ticketepson'])->name('sale.ticketepson');
    Route::get('kardex/index/{search?}', [KardexController::class, 'index'])->name('kardex.index');
    Route::get('kardex/show/{id}', [KardexController::class, 'show'])->name('kardex.show');
    Route::get('kardex/showdetail/{id}', [KardexController::class, 'showDetail'])->name('kardex.showDetail');
    Route::get('returnsale/ticket/{returnsale}', [ReturnSaleController::class, 'ticket'])->name('returnsale.ticket');
    Route::get('previewposclose', [PosController::class, 'previewclose'])->name('pos.previewclose');
    Route::get('/previewcloseConfirmar', [PosController::class, 'previewcloseConfirmar'])->name('previewcloseConfirmar');
    Route::get('/reporteinventario', [ReportController::class, 'reporteinventario'])->name('report.reporteinventario');
    Route::get('/accountcustomer/{sale}', [AccountStatusCustomerController::class, 'list_show'])->name('accountsattuscustomer.list_show');
    Route::get('/producto/ajuste', [ProductController::class, 'settings'])->name('product.settings');
    Route::post('/producto/saveajuste', [ProductController::class, 'saveSettings'])->name('product.saveSettings');

    Route::get('/recibopago/{id}', [SalePaymentController::class, 'print'])->name('salepayment.print');

    Route::get('/cierre-caja/{pos}', [PosController::class, 'cierre'])
        ->name('cierre.caja');

    Route::get('/reporte-sale', [SaleController::class, 'report_sale'])
        ->name('sale.report_sale');
    Route::get('/reporte-ventas', [SaleController::class, 'reporte'])
        ->name('sale.reporte');
    Route::get('/reporte-ventas-dia', [SaleController::class, 'reporteTotalesPorDia'])
        ->name('sale.reporte.dia');
    Route::get('/reporte-inventario', [ProductController::class, 'reporteValorInventario'])
        ->name('inventario.reporte');

    /* |--------------------------------------------------------------------------
    | REPORTES |
    -------------------------------------------------------------------------- */
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
        Route::get('/profit', 'profit')->name('profit');
        Route::get('/cash-flow', 'cashFlow')->name('cash-flow');
        Route::get('/payment-methods', 'paymentMethods')->name('payment-methods');
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

        Route::get('/sales/pdf', 'salesPdf')
            ->name('sales.pdf');

        Route::get('/sales/products/pdf', 'salesProductsPdf')
            ->name('sales.products.pdf');

        Route::get('/sales/payment-methods/pdf', 'salesPaymentMethodsPdf')
            ->name('sales.payment-methods.pdf');

        Route::get('/sales/customers/pdf', 'salesCustomersPdf')
            ->name('sales.customers.pdf');


        /*
|--------------------------------------------------------------------------
| PDF - INVENTARIO
|--------------------------------------------------------------------------
*/

        Route::get('/inventory/pdf', 'inventoryPdf')
            ->name('inventory.pdf');

        Route::get('/inventory/valuation/pdf', 'inventoryValuationPdf')
            ->name('inventory.valuation.pdf');

        Route::get('/inventory/low-stock/pdf', 'inventoryLowStockPdf')
            ->name('inventory.low-stock.pdf');

        Route::get('/inventory/kardex/pdf', 'kardexPdf')
            ->name('inventory.kardex.pdf');


        /*
|--------------------------------------------------------------------------
| PDF - COMPRAS
|--------------------------------------------------------------------------
*/

        Route::get('/purchases/pdf', 'purchasesPdf')
            ->name('purchases.pdf');

        Route::get('/purchases/products/pdf', 'purchasesProductsPdf')
            ->name('purchases.products.pdf');

        Route::get('/purchases/suppliers/pdf', 'purchasesSuppliersPdf')
            ->name('purchases.suppliers.pdf');


        /*
|--------------------------------------------------------------------------
| PDF - GASTOS
|--------------------------------------------------------------------------
*/

        Route::get('/expenses/pdf', 'expensesPdf')
            ->name('expenses.pdf');

        Route::get('/expenses/types/pdf', 'expensesTypesPdf')
            ->name('expenses.types.pdf');

        Route::get('/expenses/payment-methods/pdf', 'expensesPaymentMethodsPdf')
            ->name('expenses.payment-methods.pdf');


        /*
|--------------------------------------------------------------------------
| PDF - FINANCIERO
|--------------------------------------------------------------------------
*/

        Route::get('/profit/pdf', 'profitPdf')
            ->name('profit.pdf');

        Route::get('/cash-flow/pdf', 'cashFlowPdf')
            ->name('cash-flow.pdf');

        Route::get('/payment-methods/pdf', 'paymentMethodsPdf')
            ->name('payment-methods.pdf');


        /*
|--------------------------------------------------------------------------
| PDF - CLIENTES
|--------------------------------------------------------------------------
*/

        Route::get('/customers/pdf', 'customersPdf')
            ->name('customers.pdf');

        Route::get('/customers/top/pdf', 'topCustomersPdf')
            ->name('customers.top.pdf');

        Route::get('/customers/inactive/pdf', 'inactiveCustomersPdf')
            ->name('customers.inactive.pdf');
    });



    /*
    Route::get('/reporte-ganancias-perdidas', [ReportController::class, 'gananciasPerdidas'])
        ->name('reporte.ganancias_perdidas');
    Route::get('/reports/profit-loss', [App\Http\Controllers\ReportController::class, 'profitLoss'])
        ->name('reports.profit_loss');
    Route::get('/reports/profit-loss-daily', [App\Http\Controllers\ReportController::class, 'profitLossDaily'])
        ->name('reports.profit_loss_daily');

    Route::get('/reporte/productos-mas-vendidos', [ReportController::class, 'productsTopSelling'])->name('reporte.productos');
    Route::get('/reporte/productos-mas-vendidos-dia', [ReportController::class, 'productsTopSellingByDate'])->name('reporte.productos.fechas');
    Route::get('/reporte/productos-menos-vendidos', [ReportController::class, 'productsLessSellingByDate'])->name('reporte.productos.menos');
    Route::get('/reporte/producto-code', [ReportController::class, 'productReportByCode'])->name('reporte.producto-code');


    Route::get('/reportesale', [ReportController::class, 'reportsale'])->name('report.sale');
    Route::post('/reportes/ventas-periodo/pdf', [ReportController::class, 'salesPeriodPDF'])->name('report.sales.period.pdf');
    Route::post('/reportes/ganancias/pdf', [ReportController::class, 'profitLossPDF'])->name('report.profit.pdf');
    Route::post('/reportes/ventas-mensuales/pdf', [ReportController::class, 'monthlySalesPDF'])->name('report.sales.month.pdf');

    Route::get('abonarventa/{id}', [AccountStatusCustomerController::class, 'abonar'])->name('accountsale.abonar');
    Route::get('accountsreceivable/', [AccountStatusCustomerController::class, 'accountsReceivable'])->name('accountstatecustomer.registro');

    Route::get('/reports/sales-by-user-pdf', [ReportController::class, 'salesByUserPdf'])
        ->name('reports.salesByUserPdf');*/
});

Route::middleware(['auth'])
    ->prefix('inventario/reportes')
    ->name('inventory.reports.')
    ->group(function () {

        Route::get('/', [ProductReports::class, 'index'])
            ->name('index');

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

Route::get('/customers/search/{q}', [CustomerController::class, 'search']);
Route::get('/suppliers/search/{q}', [SupplierController::class, 'search']);
Route::get('/products/search/{query}', [ProductController::class, 'search']);




require __DIR__ . '/auth.php';
