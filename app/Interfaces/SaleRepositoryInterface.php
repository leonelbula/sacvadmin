<?php
namespace App\Interfaces;

use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface SaleRepositoryInterface
{
    public function All(): LengthAwarePaginator;
    public function findById(int $id): Sale;
    public function create(array $data): Sale;
    public function update(int $id, array $data): Sale;
    public function delete(int $id): bool;
    public function lastSale(): ?Sale;
    public function totalSale();
    public function totalSaleDate(string $start_date, string $close_date);
    public function getSalesByPeriod(  int $userId, string $startDate, string $startTime,string $closingDate,string $closingTime);

}
