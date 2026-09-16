<?php

namespace App\Services;

use App\Actions\SaleReturn\SaleReturnCreateAction;
use App\Actions\SaleReturn\SaleReturnDeleteAction;
use App\DTOs\SaleReturnDTO;
use App\Interfaces\SaleReturnRepositoryInterface;

class SaleReturnService
{

    public function __construct(
        protected SaleReturnRepositoryInterface $saleReturnRepository,
        protected SaleReturnCreateAction $saleReturnCreateAction,
        protected SaleReturnDeleteAction $saleReturnDeleteAction
    ) {}

    public function getAllReturns()
    {
        return $this->saleReturnRepository->getAllReturns();
    }

    public function search(array $filters)
    {
        return $this->saleReturnRepository->search($filters);
    }

    public function getReturnById(int $id)
    {
        return $this->saleReturnRepository->getReturnById($id);
    }

    public function getReturnsByDateRange(string $startDate, string $endDate)
    {
        return $this->saleReturnRepository->getReturnsByDateRange($startDate, $endDate);
    }

    public function getReturnsByCustomer(int $customerId)
    {
        return $this->saleReturnRepository->getReturnsByCustomer($customerId);
    }

    public function getReturnsByProduct(int $productId)
    {
        return $this->saleReturnRepository->getReturnsByProduct($productId);
    }

    public function createReturn(SaleReturnDTO $dto, array $products)
    {
        return $this->saleReturnCreateAction->execute($dto, $products);
    }

    public function updateReturn(int $id, array $data)
    {
        return $this->saleReturnRepository->updateReturn($id, $data);
    }

    public function deleteReturn(int $id)
    {
        return $this->saleReturnDeleteAction->execute($id);
    }

    public function getSalesReturnByBox($box): array
    {
        $salesReturn = $this->saleReturnRepository->getSaleReturnsByPeriod(
            userId: $box->user_id,
            startDate: $box->start_date,
            startTime: $box->start_time,
            closingDate: $box->closing_date,
            closingTime: $box->closing_time
        );

        return [
            'salesReturn' => $salesReturn,
            'total_salesReturns' => $salesReturn->total_returns ?? 0,
            'cost_salesReturns' => $salesReturn->cost_returns ?? 0,
            'quantity_returns' => $salesReturn->quantity_returns ?? 0,
        ];
    }
}
