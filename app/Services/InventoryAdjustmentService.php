<?php

namespace App\Services;

use App\Actions\InventoryAdjustment\InventoryAdjustmentCreateAction;
use App\DTOs\InventoryAdjustmentDTO;
use App\Interfaces\InventoryAdjustmentRepositoryInterface;

class InventoryAdjustmentService
{
    public function __construct(
        protected InventoryAdjustmentCreateAction $createAction,
        protected InventoryAdjustmentRepositoryInterface $repository
    ) {}

    public function create(InventoryAdjustmentDTO $dto): mixed
    {
        return $this->createAction->execute($dto);
    }

    public function search(array $filters = [])
    {
        return $this->repository->search($filters);
    }

    public function findById(int $id): mixed
    {
        return $this->repository->findById($id);
    }
}
