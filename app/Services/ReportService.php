<?php

namespace App\Services;

use App\Interfaces\ReportRepositoryInterface;

class ReportService
{
    public function __construct(
        protected ReportRepositoryInterface $reportRepository
    ) {}


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */


    public function getDashboard(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        return $this->reportRepository->getDashboard(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getTotalSales(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        return $this->reportRepository->getTotalSales(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getTotalPurchases(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        return $this->reportRepository->getTotalPurchases(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getTotalExpenses(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        return $this->reportRepository->getTotalExpenses(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getUtility(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        return $this->reportRepository->getUtility(
            $fechaDesde,
            $fechaHasta
        );
    }



    /*
    |--------------------------------------------------------------------------
    | VENTAS
    |--------------------------------------------------------------------------
    */

    public function getSalesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getSalesReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getSalesProductsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getSalesProductsReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getSalesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getSalesPaymentMethodsReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getSalesCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getSalesCustomersReport(
            $fechaDesde,
            $fechaHasta
        );
    }

    public function getProductsByCategoryReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getProductsByCategoryReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function getInventoryReport(): array
    {
        return $this->reportRepository->getInventoryReport();
    }


    public function getInventoryValuationReport(): array
    {
        return $this->reportRepository->getInventoryValuationReport();
    }


    public function getLowStockReport(): array
    {
        return $this->reportRepository->getLowStockReport();
    }

    public function getLowStockReportPaginated(): array
    {
        return $this->reportRepository->getLowStockReportPaginated();
    }


    public function getKardexReport(
        ?int $productId = null,
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getKardexReport(
            $productId,
            $fechaDesde,
            $fechaHasta,
            50
        );
    }

    public function getKardexPdfReport(
        ?int $productId = null,
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getKardexPdfReport(
            $productId,
            $fechaDesde,
            $fechaHasta
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    public function getPurchasesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getPurchasesReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getPurchasesProductsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        return $this->reportRepository->getPurchasesProductsReport(
            $fechaDesde,
            $fechaHasta,
            $perPage
        );
    }


    public function getPurchasesSuppliersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        return $this->reportRepository->getPurchasesSuppliersReport(
            $fechaDesde,
            $fechaHasta,
            $perPage
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function getExpensesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        return $this->reportRepository->getExpensesReport(
            $fechaDesde,
            $fechaHasta,
            $perPage
        );
    }



    public function getExpensesTypesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        return $this->reportRepository->getExpensesTypesReport(
            $fechaDesde,
            $fechaHasta,
            $perPage
        );
    }


    public function getExpensesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        return $this->reportRepository->getExpensesPaymentMethodsReport(
            $fechaDesde,
            $fechaHasta,
            $perPage
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FINANCIERO
    |--------------------------------------------------------------------------
    */

    public function getProfitReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getProfitReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getCashFlowReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getCashFlowReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getPaymentMethodsReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    public function getCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getCustomersReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getTopCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getTopCustomersReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getInactiveCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getInactiveCustomersReport(
            $fechaDesde,
            $fechaHasta
        );
    }
}
