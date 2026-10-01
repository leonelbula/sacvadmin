<?php

use App\Http\Controllers\AccountStatusCustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReports;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth', 'permission:user.view'])
    ->get('/user', [UserController::class, 'index'])
    ->name('user.index');

Route::middleware(['auth', 'permission:user.create'])
    ->get('/user/create', [UserController::class, 'create'])
    ->name('user.create');

Route::middleware(['auth', 'permission:user.create'])
    ->post('/user', [UserController::class, 'store'])
    ->name('user.store');

Route::middleware(['auth', 'permission:user.view'])
    ->get('/user/{user}', [UserController::class, 'show'])
    ->name('user.show');

Route::middleware(['auth', 'permission:user.edit'])
    ->get('/user/{user}/edit', [UserController::class, 'edit'])
    ->name('user.edit');

Route::middleware(['auth', 'permission:user.edit'])
    ->put('/user/{user}', [UserController::class, 'update'])
    ->name('user.update');

Route::middleware(['auth', 'permission:user.delete'])
    ->delete('/user/{user}', [UserController::class, 'destroy'])
    ->name('user.destroy');



Route::middleware('auth')->group(function () {
    Route::resource('accountstatecustomer', AccountStatusCustomerController::class);
    Route::resource('salepyment', SalePaymentController::class);
});

Route::middleware('auth')->group(function () {

    Route::get('/role', [RoleController::class, 'index'])->middleware('permission:role.view')->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->middleware('permission:role.create')->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->middleware('permission:role.create')->name('role.store');
    Route::get('/role/{role}', [RoleController::class, 'show'])->middleware('permission:role.view')->name('role.show');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:role.edit')->name('role.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->middleware('permission:role.edit')->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->middleware('permission:role.delete')->name('role.destroy');


    Route::get('/product', [ProductController::class, 'index'])->middleware('permission:product.view')->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->middleware('permission:product.create')->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->middleware('permission:product.create')->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->middleware('permission:product.view')->name('product.show');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->middleware('permission:product.edit')->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->middleware('permission:product.edit')->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->middleware('permission:product.delete')->name('product.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->middleware('permission:category.view')->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->middleware('permission:category.create')->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->middleware('permission:category.create')->name('category.store');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->middleware('permission:category.view')->name('category.show');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->middleware('permission:category.edit')->name('category.edit');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('permission:category.edit')->name('category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('permission:category.delete')->name('category.destroy');


    Route::get('/customer', [CustomerController::class, 'index'])->middleware('permission:customer.view')->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->middleware('permission:customer.create')->name('customer.create');
    Route::post('/customer', [CustomerController::class, 'store'])->middleware('permission:customer.create')->name('customer.store');
    Route::get('/customer/{customer}', [CustomerController::class, 'show'])->middleware('permission:customer.view')->name('customer.show');
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->middleware('permission:customer.edit')->name('customer.edit');
    Route::put('/customer/{customer}', [CustomerController::class, 'update'])->middleware('permission:customer.edit')->name('customer.update');
    Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->middleware('permission:customer.delete')->name('customer.destroy');


    Route::get('/supplier', [SupplierController::class, 'index'])->middleware('permission:supplier.view')->name('supplier.index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->middleware('permission:supplier.create')->name('supplier.create');
    Route::post('/supplier', [SupplierController::class, 'store'])->middleware('permission:supplier.create')->name('supplier.store');
    Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->middleware('permission:supplier.view')->name('supplier.show');
    Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->middleware('permission:supplier.edit')->name('supplier.edit');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->middleware('permission:supplier.edit')->name('supplier.update');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->middleware('permission:supplier.delete')->name('supplier.destroy');


    Route::get('/shopping', [ShoppingController::class, 'index'])->middleware('permission:shopping.view')->name('shopping.index');
    Route::get('/shopping/create', [ShoppingController::class, 'create'])->middleware('permission:shopping.create')->name('shopping.create');
    Route::post('/shopping/store', [ShoppingController::class, 'store'])->middleware('permission:shopping.create')->name('shopping.store');
    Route::get('/shopping/{shopping}', [ShoppingController::class, 'show'])->middleware('permission:shopping.view')->name('shopping.show');
    Route::get('/shopping/{shopping}/edit', [ShoppingController::class, 'edit'])->middleware('permission:shopping.edit')->name('shopping.edit');
    Route::put('/shopping/{shopping}', [ShoppingController::class, 'update'])->middleware('permission:shopping.edit')->name('shopping.update');
    Route::delete('/shopping/{shopping}', [ShoppingController::class, 'destroy'])->middleware('permission:shopping.delete')->name('shopping.destroy');

    Route::get('/sale', [SaleController::class, 'index'])->middleware('permission:sale.view')->name('sale.index');
    Route::get('/sale/create', [SaleController::class, 'create'])->middleware('permission:sale.create')->name('sale.create');
    Route::post('/sale/store', [SaleController::class, 'store'])->middleware('permission:sale.create')->name('sale.store');
    Route::get('/sale/{sale}', [SaleController::class, 'show'])->middleware('permission:sale.view')->name('sale.show');
    Route::get('/sale/{sale}/edit', [SaleController::class, 'edit'])->middleware('permission:sale.edit')->name('sale.edit');
    Route::put('/sale/{sale}', [SaleController::class, 'update'])->middleware('permission:sale.edit')->name('sale.update');
    Route::delete('/sale/{sale}', [SaleController::class, 'destroy'])->middleware('permission:sale.delete')->name('sale.destroy');

    Route::get('/pos', [PosController::class, 'index'])->middleware('permission:pos.view')->name('pos.index');
    Route::get('/pos/create', [PosController::class, 'create'])->middleware('permission:pos.create')->name('pos.create');
    Route::post('/pos', [PosController::class, 'store'])->middleware('permission:pos.create')->name('pos.store');
    Route::post('/pos/close', [PosController::class, 'close'])->middleware('permission:pos.close')->name('pos.close');


    Route::get('/salereturn', [SaleReturnController::class, 'index'])->middleware('permission:salereturn.view')->name('salereturn.index');
    Route::get('/salereturn/create', [SaleReturnController::class, 'create'])->middleware('permission:salereturn.create')->name('salereturn.create');
    Route::post('/salereturn', [SaleReturnController::class, 'store'])->middleware('permission:salereturn.create')->name('salereturn.store');
    Route::get('/salereturn/{saleReturn}', [SaleReturnController::class, 'show'])->middleware('permission:salereturn.view')->name('salereturn.show');
    Route::get('/salereturn/{saleReturn}/edit', [SaleReturnController::class, 'edit'])->middleware('permission:salereturn.edit')->name('salereturn.edit');
    Route::put('/salereturn/{saleReturn}', [SaleReturnController::class, 'update'])->middleware('permission:salereturn.edit')->name('salereturn.update');
    Route::delete('/salereturn/{saleReturn}', [SaleReturnController::class, 'destroy'])->middleware('permission:salereturn.delete')->name('salereturn.destroy');


    Route::get('/expense', [ExpenseController::class, 'index'])->middleware('permission:expense.view')->name('expense.index');
    Route::get('/expense/create', [ExpenseController::class, 'create'])->middleware('permission:expense.create')->name('expense.create');
    Route::post('/expense', [ExpenseController::class, 'store'])->middleware('permission:expense.create')->name('expense.store');
    Route::get('/expense/{expence}', [ExpenseController::class, 'show'])->middleware('permission:expense.view')->name('expense.show');
    Route::get('/expense/{expence}/edit', [ExpenseController::class, 'edit'])->middleware('permission:expense.edit')->name('expense.edit');
    Route::put('/expense/{expence}', [ExpenseController::class, 'update'])->middleware('permission:expense.edit')->name('expense.update');
    Route::delete('/expense/{expence}', [ExpenseController::class, 'destroy'])->middleware('permission:expense.delete')->name('expense.destroy');


    Route::get('/kardex/index/{search?}', [KardexController::class, 'index'])->middleware('permission:kardex.view')->name('kardex.index');
    Route::get('/kardex/show/{id}', [KardexController::class, 'show'])->middleware('permission:kardex.view')->name('kardex.show');
    Route::get('kardex/showdetail/{id}', [KardexController::class, 'showDetail'])->middleware('permission:kardex.view')->name('kardex.showDetail');


    Route::get('/report', [ReportController::class, 'index'])->middleware('permission:report.view')->name('report.index');
    Route::get('/report/sales', [ReportController::class, 'sales'])->middleware('permission:report.sales')->name('report.sales');
    Route::get('/report/shopping', [ReportController::class, 'shopping'])->middleware('permission:report.shopping')->name('report.shopping');
    Route::get('/report/expenses', [ReportController::class, 'expenses'])->middleware('permission:report.expenses')->name('report.expenses');
    Route::get('/report/inventory', [ReportController::class, 'inventory'])->middleware('permission:report.inventory')->name('report.inventory');
    Route::get('/report/kardex', [ReportController::class, 'kardex'])->middleware('permission:report.kardex')->name('report.kardex');


    Route::get('/company', [CompanyController::class, 'show'])->middleware('permission:company.view')->name('company.show');
    Route::get('/company/edit', [CompanyController::class, 'edit'])->middleware('permission:company.edit')->name('company.edit');
    Route::put('/company', [CompanyController::class, 'update'])->middleware('permission:company.edit')->name('company.update');


    //**/ */

    Route::get('/product/search/{query}', [ProductController::class, 'search'])->name('product.search');
    Route::get('/producto/ajuste', [ProductController::class, 'settings'])->name('product.settings');
    Route::post('/producto/saveajuste', [ProductController::class, 'saveSettings'])->name('product.saveSettings');
    Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sale.print');
    Route::get('sale/ticket/{sale}', [SaleController::class, 'ticket'])->name('sale.ticket');
    Route::get('sale/ticket2/{sale}', [SaleController::class, 'ticketepson'])->name('sale.ticketepson');



    Route::get('salereturn/ticket/{salereturn}', [SaleReturnController::class, 'ticket'])->name('salereturn.ticket');
    Route::get('previewposclose', [PosController::class, 'previewclose'])->name('pos.previewclose');
    Route::get('/accountcustomer/{sale}', [AccountStatusCustomerController::class, 'list_show'])->name('accountsattuscustomer.list_show');


    Route::get('/reporteinventario', [ReportController::class, 'reporteinventario'])->name('report.reporteinventario');
    Route::get('/recibopago/{id}', [SalePaymentController::class, 'print'])->name('salepayment.print');

    Route::get('/reporte-sale', [SaleController::class, 'report_sale'])
        ->name('sale.report_sale');
    Route::get('/reporte-ventas', [SaleController::class, 'reporte'])
        ->name('sale.reporte');
    Route::get('/reporte-ventas-dia', [SaleController::class, 'reporteTotalesPorDia'])
        ->name('sale.reporte.dia');
    Route::get('/reporte-inventario', [ProductController::class, 'reporteValorInventario'])
        ->name('inventario.reporte');


    Route::get('sales/search-sale/{saleNumber}', [SaleController::class, 'searchSale'])
        ->name('search-sale');


    Route::prefix('inventory/adjustments')
        ->name('inventory.adjustments.')
        ->group(function () {

            Route::get(
                '/',
                [InventoryAdjustmentController::class, 'index']
            )->name('index');

            Route::get(
                '/create',
                [InventoryAdjustmentController::class, 'create']
            )->name('create');

            Route::post(
                '/',
                [InventoryAdjustmentController::class, 'store']
            )->name('store');

            Route::get(
                '/{id}',
                [InventoryAdjustmentController::class, 'show']
            )->name('show');
        });


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
Route::get('/supplier/search/{query}', [SupplierController::class, 'search']);
Route::get('/products/search/{query}', [ProductController::class, 'search']);




require __DIR__ . '/auth.php';
