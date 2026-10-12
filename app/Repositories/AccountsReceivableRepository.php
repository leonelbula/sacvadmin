<?php

namespace App\Repositories;

use App\Interfaces\AccountsReceivableRepositoryInterface;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AccountsReceivableRepository implements AccountsReceivableRepositoryInterface
{
    private function query(array $filters = []): Builder
    {
        $query = Sale::query()
            ->with('customer')
            ->where('balance', '>', 0);

        if (!empty($filters['search'])) {
            $search = trim($filters['search']);

            $query->where(function (Builder $query) use ($search) {
                $query->where('sale_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function (Builder $customer) use ($search) {
                        $customer->where('full_name', 'like', "%{$search}%")
                            ->orWhere('identification', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['fecha_desde'])) {
            $query->whereDate(
                'date_sale',
                '>=',
                $filters['fecha_desde']
            );
        }

        if (!empty($filters['fecha_hasta'])) {
            $query->whereDate(
                'date_sale',
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
            ->orderByDesc('date_sale')
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
            ->whereNotNull('customer_id')
            ->distinct()
            ->count('customer_id');
    }

    public function findAccount(int $id): Sale
    {
        return Sale::with('customer')
            ->where('balance', '>', 0)
            ->findOrFail($id);
    }
    
}
