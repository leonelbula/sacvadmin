<?php

namespace App\Interfaces;

use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SupplierRepositoryInterface
{
    public function all(): LengthAwarePaginator;
    public function find(int $id): Supplier;
    public function create(array $data): Supplier;
    public function update(int $id, array $data): Supplier;
    public function delete(int $id): bool;
    public function search(string $query);
}
