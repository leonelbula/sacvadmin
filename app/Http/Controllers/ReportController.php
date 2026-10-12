<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use App\Services\ReportPdfService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService,
        protected ReportPdfService $reportPdfService
    ) {}

    private function dates(): array
    {
        return request()->validate([
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => ['nullable', 'date', 'after_or_equal:fecha_desde'],
        ]);
    }

    /**
     * Panel principal de reportes.
     */

    public function index()
    {
        $filters = $this->dates();

        $data = $this->reportService->getDashboard(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );

        return view('reports.index', [

            ...$data,

            'fechaDesde' =>
            $filters['fecha_desde'] ?? null,

            'fechaHasta' =>
            $filters['fecha_hasta'] ?? null,

        ]);
    }

    public function kardex(Request $request)
    {
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $data = $this->reportService->getKardexReport($fechaDesde, $fechaHasta);
        return view('reports.kardex', [
            'kardex' => $data['kardex'],
            'quantity' => $data['quantity'],
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ]);
    }


    /**
     * Reporte de ventas.
     */
    public function sales(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Productos vendidos.
     */
    public function salesProducts(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesProductsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales-products', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Ventas por método de pago.
     */
    public function salesPaymentMethods(): View
    {

        $filters = $this->dates();

        $data = $this->reportService->getSalesPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view(
            'reports.sale.sales-payment-methods',

            [
                ...$data,
                'fechaDesde' => $filters['fecha_desde'] ?? null,
                'fechaHasta' => $filters['fecha_hasta'] ?? null,
            ]
        );
    }


    /**
     * Ventas por cliente.
     */
    public function salesCustomers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales-customers', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


public function getProductsByCategory(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getProductsByCategoryReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.products-by-category', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }






    /**
     * Reporte de inventario.
     */
    public function inventory(): View
    {

        $data = $this->reportService->getInventoryReport();

        return view('reports.inventory.inventory', $data);
    }


    /**
     * Valorización del inventario.
     */
    public function inventoryValuation(): View
    {
        $data = $this->reportService->getInventoryValuationReport();

        return view('reports.inventory.inventory-valuation', $data);
    }


    /**
     * Productos con stock bajo.
     */
    public function inventoryLowStock(): View
    {
        $data = $this->reportService->getLowStockReportPaginated();

        return view('reports.inventory.inventory-low-stock', $data);
    }


    /**
     * Kardex.
     */
    public function inventoryKardex(): View
    {
        $filters = $this->dates();
        $product_id = request()->input('product_id');
        $data = $this->reportService->getKardexReport($product_id ?? null, $filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.inventory.kardex', $data);
    }


    /**
     * Reporte de compras.
     */
    public function purchases(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases', $data);
    }


    /**
     * Productos comprados.
     */
    public function purchasesProducts(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesProductsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases-products', $data);
    }


    /**
     * Compras por proveedor.
     */
    public function purchasesSuppliers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesSuppliersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases-suppliers', $data);
    }


    /**
     * Reporte de gastos.
     */
    public function expenses()
    {
        $filters = $this->dates();
        $data = $this->reportService->getExpensesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);
        return view('reports.expenses.expenses', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Gastos por tipo.
     */
    public function expensesTypes(): View
    {

        $filters = $this->dates();
        $data = $this->reportService->getExpensesTypesReport(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );

        return view('reports.expenses.expenses-types', $data);
    }


    /**
     * Gastos por método de pago.
     */
    public function expensesPaymentMethods(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getExpensesPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.expenses.expenses-payment-methods', $data);
    }


    /**
     * Reporte de utilidad.
     */
    public function profit(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getProfitReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.profit', $data);
    }


    /**
     * Flujo de caja.
     */
    public function cashFlow(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getCashFlowReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.cash-flow', $data);
    }


    /**
     * Reporte general de métodos de pago.
     */
    public function paymentMethods(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.payment-methods', $data);
    }


    /**
     * Reporte de clientes.
     */
    public function customers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers', $data);
    }


    /**
     * Mejores clientes.
     */
    public function customersTop(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getTopCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers-top', $data);
    }


    /**
     * Clientes inactivos.
     */
    public function customersInactive(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getInactiveCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers-inactive', $data);
    }


    /*
|--------------------------------------------------------------------------
| PDF - VENTAS
|--------------------------------------------------------------------------
*/

    public function salesPdf(Request $request): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->sales(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }




    public function salesProductsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->salesProducts(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function salesPaymentMethodsPdf(): Response
    {
         $filters = $this->dates();
        return $this->reportPdfService->salesPaymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function salesCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->salesCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function getProductsByCategoryPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->getProductsByCategory(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - INVENTARIO
|--------------------------------------------------------------------------
*/

    public function inventoryPdf(): Response
    {
        return $this->reportPdfService->inventory();
    }

    public function inventoryValuationPdf(): Response
    {
        return $this->reportPdfService->inventoryValuation();
    }

    public function inventoryLowStockPdf(): Response
    {
        return $this->reportPdfService->inventoryLowStock();
    }

    public function kardexPdf(): Response
    {
        $filters = $this->dates();
        $product_id = request()->input('product_id');
        return $this->reportPdfService->kardex(
            $product_id ?? null,
             $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - COMPRAS
|--------------------------------------------------------------------------
*/

    public function purchasesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchases(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function purchasesProductsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchasesProducts(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function purchasesSuppliersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchasesSuppliers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - GASTOS
|--------------------------------------------------------------------------
*/

    public function expensesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expenses(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function expensesTypesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expensesTypes(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function expensesPaymentMethodsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expensesPaymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - FINANCIERO
|--------------------------------------------------------------------------
*/

    public function profitPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->profit(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function cashFlowPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->cashFlow(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function paymentMethodsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->paymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - CLIENTES
|--------------------------------------------------------------------------
*/

    public function customersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->customers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function topCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->topCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function inactiveCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->inactiveCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }
}
