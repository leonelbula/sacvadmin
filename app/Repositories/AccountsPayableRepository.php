<?php

namespace App\Repositories;

use App\Interfaces\AccountsPayableRepositoryInterface;
use App\Models\Sale;
use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AccountsPayableRepository implements AccountsPayableRepositoryInterface
{
    private function query(array $filters = []): Builder
    {
        $query = Shopping::query()
            ->with('supplier')
            ->where('balance', '>', 0);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);

            $query->where(function (Builder $query) use ($search) {
                $query->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function (Builder $supplier) use ($search) {
                        $supplier->where('full_name', 'like', "%{$search}%")
                            ->orWhere('identification', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate(
                'shopping_date',
                '>=',
                $filters['fecha_desde']
            );
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate(
                'shopping_date',
                '<=',
                $filters['fecha_hasta']
            );
        }

        return $query;
    }

    public function getAccountsReceivable(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->query($filters)
            ->orderByDesc('shopping_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function getTotalReceivable(
        array $filters = []
    ): float {
        return (float) $this->query($filters)->sum('balance');
    }

    public function getPendingAccountsCount(
        array $filters = []
    ): int {
        return $this->query($filters)->count();
    }

    public function getCustomersWithDebtCount(
        array $filters = []
    ): int {
        return $this->query($filters)
            ->whereNotNull('supplier_id')
            ->distinct()
            ->count('supplier_id');
    }

    public function findAccount(int $id): Shopping
    {
        return Shopping::with('supplier')
            ->where('balance', '>', 0)
            ->findOrFail($id);
    }

}
