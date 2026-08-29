<?php

namespace App\Services;

use App\Actions\Sale\SaleCreateAction;
use App\DTOs\SaleDTO;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleService
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected SaleCreateAction $saleCreateAction
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

    public function deleteSale(int $id): bool
    {
        return $this->saleRepository->delete($id);
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
}
