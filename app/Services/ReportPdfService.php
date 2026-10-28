<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReportPdfService
{
    public function __construct(
        protected ReportService $reportService
    ) {}


    /*
    |--------------------------------------------------------------------------
    | VENTAS
    |--------------------------------------------------------------------------
    */

    public function sales($date_from = null, $date_until= null,): Response
    {
        $data = $this->reportService->getSalesReport($date_from, $date_until,0);

        return $this->pdf(
            'reports.pdf.sales',
            $data,
            'reporte-ventas'
        );
    }


    public function salesProducts($date_from = null, $date_until= null): Response
    {
        $data = $this->reportService
            ->getSalesProductsReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.sale.sales-products',
            $data,
            'productos-vendidos'
        );
    }


    public function salesPaymentMethods($date_from = null, $date_until= null): Response
    {
        $data = $this->reportService
            ->getSalesPaymentMethodsReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.sale.sales-payment-methods',
            $data,
            'ventas-metodos-pago'
        );
    }


    public function salesCustomers($date_from = null, $date_until= null): Response
    {
        $data = $this->reportService
            ->getSalesCustomersReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.sale.sales-customers',
            $data,
            'ventas-clientes'
        );
    }

    public function getProductsByCategory(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): Response {
        $data = $this->reportService
            ->getProductsByCategoryReport($fechaDesde, $fechaHasta);

        return $this->pdf(
            'reports.pdf.sale.products-by-category',
            $data,
            'productos-por-categoria'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function inventory($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getInventoryReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.inventory.inventory',
            $data,
            'inventario'
        );
    }


    public function inventoryValuation($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getInventoryValuationReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.inventory.inventory-valuation',
            $data,
            'valoracion-inventario'
        );
    }


    public function inventoryLowStock($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getLowStockReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.inventory.inventory-low-stock',
            $data,
            'stock-bajo'
        );
    }


    public function kardex($product_id = null,$date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getKardexPdfReport( $product_id, $date_from, $date_until);

        return $this->pdf(
            'reports.pdf.inventory.kardex',
            $data,

            'kardex'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    public function purchases($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getPurchasesReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.shopping.purchases',
            $data,
            'reporte-compras'
        );
    }


    public function purchasesProducts($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getPurchasesProductsReport($date_from, $date_until,0);

        return $this->pdf(
            'reports.pdf.shopping.purchases-products',
            $data,
            'productos-comprados'
        );
    }


    public function purchasesSuppliers($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getPurchasesSuppliersReport($date_from, $date_until, 0);

        return $this->pdf(
            'reports.pdf.shopping.purchases-suppliers',
            $data,
            'compras-proveedores'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function expenses($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getExpensesReport($date_from, $date_until,0 );

        return $this->pdf(
            'reports.pdf.expenses.expenses',
            $data,
            'reporte-gastos'
        );
    }


    public function expensesTypes($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getExpensesTypesReport($date_from, $date_until, 0);

        return $this->pdf(
            'reports.pdf.expenses.expenses-types',
            $data,
            'gastos-por-tipo'
        );
    }


    public function expensesPaymentMethods($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getExpensesPaymentMethodsReport($date_from, $date_until, 0);

        return $this->pdf(
            'reports.pdf.expenses.expenses-payment-methods',
            $data,
            'gastos-metodos-pago'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FINANCIERO
    |--------------------------------------------------------------------------
    */

    public function profit($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getProfitReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.financial.profit',
            $data,
            'utilidad'
        );
    }


    public function cashFlow($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getCashFlowReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.financial.cash-flow',
            $data,
            'flujo-caja'
        );
    }


    public function paymentMethods($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getPaymentMethodsReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.financial.payment-methods',
            $data,
            'metodos-pago'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    public function customers($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getCustomersReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.customers.customers',
            $data,
            'compras-por-clientes'
        );
    }


    public function topCustomers($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getTopCustomersReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.customers.customers-top',
            $data,
            'mejores-clientes'
        );
    }


    public function inactiveCustomers($date_from = null, $date_until = null): Response
    {
        $data = $this->reportService
            ->getInactiveCustomersReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.customers.customers-inactive',
            $data,
            'clientes-inactivos'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERAR PDF
    |--------------------------------------------------------------------------
    */

    protected function pdf(
        string $view,
        array $data,
        string $filename
    ): Response {

        return Pdf::loadView(
            $view,
            $data
        )
            ->setPaper('letter', 'landscape')
            ->stream(
                $filename . '.pdf'
            );
    }
}
