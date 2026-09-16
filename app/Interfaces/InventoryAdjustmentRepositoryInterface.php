<?php

namespace App\Interfaces;

use App\DTOs\InventoryAdjustmentDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface InventoryAdjustmentRepositoryInterface
{
    public function create(array $data): mixed;

    public function findById(int $id): mixed;

    public function search(array $filters = []): LengthAwarePaginator;
}
