<?php

namespace App\Repositories;

use App\DTOs\InventoryAdjustmentDTO;
use App\Interfaces\InventoryAdjustmentRepositoryInterface;
use App\Models\InventoryAdjustment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InventoryAdjustmentRepository implements InventoryAdjustmentRepositoryInterface
{
    public function create(array $data): mixed
    {
        return InventoryAdjustment::create($data);
    }

    public function findById(int $id): mixed
    {
        return InventoryAdjustment::with([
            'product',
            'user',
        ])->find($id);
    }

    public function search(array $filters = []): LengthAwarePaginator
    {
        $query = InventoryAdjustment::query()
            ->with([
                'product',
                'user',
            ]);

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['movement_type'])) {
            $query->where(
                'movement_type',
                $filters['movement_type']
            );
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate(
                'created_at',
                '>=',
                $filters['date_from']
            );
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate(
                'created_at',
                '<=',
                $filters['date_to']
            );
        }

        return $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();
    }
}
