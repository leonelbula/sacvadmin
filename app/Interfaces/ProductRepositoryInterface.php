<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface ProductRepositoryInterface
{
    public function searchProducts(?string $search = null, int $perPage = 10): LengthAwarePaginator;
    public function searchProductSale(?string $search = null): Collection;
    public function getAllProducts(): LengthAwarePaginator;
    public function findOrFail(int $id): Product;
    public function lockForUpdate(int $id): Product; // Crítico para evitar Race Conditions
    public function create(array $data): Product;
    public function update(int $id, array $data): Product;
    public function delete(int $id): bool;
    public function getNextCode(): string;
    public function countProduct(): int;
}
