<?php

namespace App\Interfaces;

interface ReportRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function getDashboard( ?string $fechaDesde = null, ?string $fechaHasta = null ): array;

    public function getTotalSales( ?string $fechaDesde = null, ?string $fechaHasta = null ): int|float;

    public function getTotalPurchases( ?string $fechaDesde = null, ?string $fechaHasta = null ): int|float;

    public function getTotalExpenses( ?string $fechaDesde = null, ?string $fechaHasta = null ): int|float;

    public function getUtility( ?string $fechaDesde = null, ?string $fechaHasta = null ): int|float;


    /*
    |--------------------------------------------------------------------------
    | VENTAS
    |--------------------------------------------------------------------------
    */

    public function getSalesReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getSalesProductsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getSalesPaymentMethodsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getSalesCustomersReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function getInventoryReport(): array;

    public function getInventoryValuationReport(): array;

    public function getLowStockReport(): array;

    public function getKardexReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;


    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    public function getPurchasesReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getPurchasesProductsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getPurchasesSuppliersReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function getExpensesReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getExpensesTypesReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getExpensesPaymentMethodsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;


    /*
    |--------------------------------------------------------------------------
    | FINANCIERO
    |--------------------------------------------------------------------------
    */

    public function getProfitReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getCashFlowReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getPaymentMethodsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    public function getCustomersReport(): array;

    public function getTopCustomersReport(?string $fechaDesde = null, ?string $fechaHasta = null): array;

    public function getInactiveCustomersReport(): array;
}

