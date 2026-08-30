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


    public function getKardexReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getKardexReport(
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
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getPurchasesProductsReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getPurchasesSuppliersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getPurchasesSuppliersReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function getExpensesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getExpensesReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getExpensesTypesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getExpensesTypesReport(
            $fechaDesde,
            $fechaHasta
        );
    }


    public function getExpensesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        return $this->reportRepository->getExpensesPaymentMethodsReport(
            $fechaDesde,
            $fechaHasta
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

    public function getCustomersReport(): array
    {
        return $this->reportRepository->getCustomersReport();
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


    public function getInactiveCustomersReport(): array
    {
        return $this->reportRepository->getInactiveCustomersReport();
    }
}
