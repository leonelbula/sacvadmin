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

    public function sales($date_from = null, $date_until= null): Response
    {
        $data = $this->reportService->getSalesReport($date_from, $date_until);

        return $this->pdf(
            'reports.pdf.sales',
            $data,
            'reporte-ventas'
        );
    }


    public function salesProducts(): Response
    {
        $data = $this->reportService
            ->getSalesProductsReport();

        return $this->pdf(
            'reports.pdf.sales-products',
            $data,
            'productos-vendidos'
        );
    }


    public function salesPaymentMethods(): Response
    {
        $data = $this->reportService
            ->getSalesPaymentMethodsReport();

        return $this->pdf(
            'reports.pdf.sales-payment-methods',
            $data,
            'ventas-metodos-pago'
        );
    }


    public function salesCustomers(): Response
    {
        $data = $this->reportService
            ->getSalesCustomersReport();

        return $this->pdf(
            'reports.pdf.sales-customers',
            $data,
            'ventas-clientes'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function inventory(): Response
    {
        $data = $this->reportService
            ->getInventoryReport();

        return $this->pdf(
            'reports.pdf.inventory',
            $data,
            'inventario'
        );
    }


    public function inventoryValuation(): Response
    {
        $data = $this->reportService
            ->getInventoryValuationReport();

        return $this->pdf(
            'reports.pdf.inventory-valuation',
            $data,
            'valoracion-inventario'
        );
    }


    public function inventoryLowStock(): Response
    {
        $data = $this->reportService
            ->getLowStockReport();

        return $this->pdf(
            'reports.pdf.inventory-low-stock',
            $data,
            'stock-bajo'
        );
    }


    public function kardex(): Response
    {
        $data = $this->reportService
            ->getKardexReport();

        return $this->pdf(
            'reports.pdf.kardex',
            $data,
            'kardex'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    public function purchases(): Response
    {
        $data = $this->reportService
            ->getPurchasesReport();

        return $this->pdf(
            'reports.pdf.purchases',
            $data,
            'reporte-compras'
        );
    }


    public function purchasesProducts(): Response
    {
        $data = $this->reportService
            ->getPurchasesProductsReport();

        return $this->pdf(
            'reports.pdf.purchases-products',
            $data,
            'productos-comprados'
        );
    }


    public function purchasesSuppliers(): Response
    {
        $data = $this->reportService
            ->getPurchasesSuppliersReport();

        return $this->pdf(
            'reports.pdf.purchases-suppliers',
            $data,
            'compras-proveedores'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function expenses(): Response
    {
        $data = $this->reportService
            ->getExpensesReport();

        return $this->pdf(
            'reports.pdf.expenses',
            $data,
            'reporte-gastos'
        );
    }


    public function expensesTypes(): Response
    {
        $data = $this->reportService
            ->getExpensesTypesReport();

        return $this->pdf(
            'reports.pdf.expenses-types',
            $data,
            'gastos-por-tipo'
        );
    }


    public function expensesPaymentMethods(): Response
    {
        $data = $this->reportService
            ->getExpensesPaymentMethodsReport();

        return $this->pdf(
            'reports.pdf.expenses-payment-methods',
            $data,
            'gastos-metodos-pago'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FINANCIERO
    |--------------------------------------------------------------------------
    */

    public function profit(): Response
    {
        $data = $this->reportService
            ->getProfitReport();

        return $this->pdf(
            'reports.pdf.profit',
            $data,
            'utilidad'
        );
    }


    public function cashFlow(): Response
    {
        $data = $this->reportService
            ->getCashFlowReport();

        return $this->pdf(
            'reports.pdf.cash-flow',
            $data,
            'flujo-caja'
        );
    }


    public function paymentMethods(): Response
    {
        $data = $this->reportService
            ->getPaymentMethodsReport();

        return $this->pdf(
            'reports.pdf.payment-methods',
            $data,
            'metodos-pago'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    public function customers(): Response
    {
        $data = $this->reportService
            ->getCustomersReport();

        return $this->pdf(
            'reports.pdf.customers',
            $data,
            'clientes'
        );
    }


    public function topCustomers(): Response
    {
        $data = $this->reportService
            ->getTopCustomersReport();

        return $this->pdf(
            'reports.pdf.customers-top',
            $data,
            'mejores-clientes'
        );
    }


    public function inactiveCustomers(): Response
    {
        $data = $this->reportService
            ->getInactiveCustomersReport();

        return $this->pdf(
            'reports.pdf.customers-inactive',
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
