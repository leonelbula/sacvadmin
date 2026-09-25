<?php
namespace App\Interfaces;


use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface ShoppingRepositoryInterface
{
    public function All(): array;
    public function findById(int $id): Shopping;
    public function create(array $data): Shopping;
    public function update(int $id, array $data): Shopping;
    public function delete(int $id): bool;
    public function totalShopping();
    public function totalShoppingDate(string $start_date, string $close_date);
    public function getShoppingByPeriod(  int $userId, string $startDate, string $startTime,string $closingDate,string $closingTime);
    public function searchShopping(array $filters): LengthAwarePaginator;

}
