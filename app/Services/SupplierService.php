<?php

namespace App\Services;

use App\Actions\Supplier\CreateSupplierAction;
use App\Actions\Supplier\DeleteSupplierAction;
use App\Actions\Supplier\UpdateSupplierAction;
use App\DTOs\SupplierDTO;
use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierService
{
    public function __construct(
        protected SupplierRepositoryInterface $supplier_repository,
        protected CreateSupplierAction $create_supplier_action,
        protected UpdateSupplierAction $update_supplier_action,
        protected DeleteSupplierAction $delete_supplier_action

    ) {}
    public function All(): LengthAwarePaginator
    {
        return $this->supplier_repository->all();
    }
    public function find(int $id): Supplier
    {
        return $this->supplier_repository->find($id);
    }
    public function create(SupplierDTO $dto): Supplier
    {
        return $this->create_supplier_action->execute($dto);
    }
    public function update(int $id, SupplierDTO $data): Supplier
    {
        return $this->update_supplier_action->execute($id, $data);
    }
    public function delete(int $id): bool
    {
        return $this->delete_supplier_action->execute($id);
    }
    public function search(string $query)
    {
        return $this->supplier_repository->search($query);
    }
}
