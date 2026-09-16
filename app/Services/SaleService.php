<?php

namespace App\Services;

use App\Actions\Sale\SaleCreateAction;
use App\Actions\Sale\SaleDeleteAction;
use App\Actions\Sale\SaleUpdateAction;
use App\DTOs\SaleDTO;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected SaleCreateAction $saleCreateAction,
        protected SaleUpdateAction $sale_update_action,
        protected SaleDeleteAction $sale_delete
    ) {}

    public function getPaginatedSales(): LengthAwarePaginator
    {
        return $this->saleRepository->All();
    }

    public function findSale(int $id): Sale
    {
        return $this->saleRepository->findById($id);
    }

    public function storeSale(SaleDTO $dto, array $products): Sale
    {
        // El servicio recupera los productos del controlador y los delega a la acción
        return $this->saleCreateAction->execute($dto, $products);
    }

    public function updateSale(
        int $id,
        SaleDTO $dto,
        array $products
    ) {
        return $this->sale_update_action->execute($id, $dto, $products);
    }

    public function deleteSale(int $id): bool
    {
        return $this->sale_delete->execute($id);
    }
    public function getSalesByBox($box): array
    {
        $sales = $this->saleRepository->getSalesByPeriod(
            userId: $box->user_id,
            startDate: $box->start_date,
            startTime: $box->start_time,
            closingDate: $box->closing_date,
            closingTime: $box->closing_time
        );

        return [
            'sales' => $sales,

            'quantity' => $sales->sum('quantity'),

            'total_sales' => $sales->sum('total'),
        ];
    }

    public function searchSales(array $filters): LengthAwarePaginator
    {
        return $this->saleRepository->searchSales($filters);
    }

    public function findBySaleNumber(int $saleNumber)
    {
        return $this->saleRepository->findBySaleNumber($saleNumber);
    }
}
