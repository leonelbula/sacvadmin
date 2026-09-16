<?php

namespace App\Interfaces;

use App\DTOs\SaleReturnDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SaleReturnRepositoryInterface
{
    public function getAllReturns(): LengthAwarePaginator;
    public function search(array $filters): LengthAwarePaginator;
    public function getReturnById(int $id);
    public function lastReturnNumber(): int;
    public function getReturnsByDateRange(string $startDate, string $endDate);
    public function getReturnsByCustomer(int $customerId);
    public function getReturnsByProduct(int $productId);
    public function createReturn(array $datas);
    public function updateReturn(int $id, array $data);
    public function deleteReturn(int $id);
    public function getSaleReturnsByPeriod(int $userId, string $startDate, string $startTime, string $closingDate, string $closingTime);
}
