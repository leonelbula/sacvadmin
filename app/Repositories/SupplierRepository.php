<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return Supplier::orderBy('full_name', 'asc')->paginate(10);
    }
    public function find(int $id): Supplier
    {
        return Supplier::find($id);
    }
    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }
    public function update(int $id, array $data): Supplier
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }
    public function delete(int $id): bool
    {
        $supplier = Supplier::findOrFail($id);
        if (!$supplier) {
            return false;
        }

        return (bool) $supplier->delete();
    }
    public function search(string $query)
    {
        return  Supplier::where('full_name', 'LIKE', "%{$query}%")
            ->orWhere('identification', 'LIKE', "%{$query}%")
            ->paginate(10);
    }
}
