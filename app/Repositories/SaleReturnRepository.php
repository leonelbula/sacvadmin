<?php

namespace App\Repositories;

use App\DTOs\SaleReturnDTO;
use App\Interfaces\SaleReturnRepositoryInterface;
use Carbon\Carbon;
use App\Models\SaleReturn;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleReturnRepository implements SaleReturnRepositoryInterface
{
    public function getAllReturns(): LengthAwarePaginator
    {
        return SaleReturn::paginate(10);
    }

    public function search(array $filters): LengthAwarePaginator
    {
        return SaleReturn::query()
            ->with(['customer'])

            // Cliente
            ->when($filters['customer_name'] ?? null, function ($query, $customerName) {
                $query->whereHas('customer', function ($customerQuery) use ($customerName) {
                    $customerQuery->where(
                        'full_name',
                        'LIKE',
                        "%{$customerName}%"
                    );
                });
            })

            // Número de factura
            ->when($filters['return_number'] ?? null, function ($query, $saleReturnNumber) {
                $query->where('return_number', $saleReturnNumber);
            })


            // Fecha inicial
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })

            // Fecha final
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })

            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function getReturnById(int $id)
    {
        return SaleReturn::find($id);
    }
    public function lastReturnNumber(): int
    {
        $lastReturn = SaleReturn::latest('return_number')->first();
        return $lastReturn ? $lastReturn->return_number : 0;
    }

    public function getReturnsByDateRange(string $startDate, string $endDate)
    {
        return SaleReturn::whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function getReturnsByCustomer(int $customerId)
    {
        return SaleReturn::where('customer_id', $customerId)->get();
    }

    public function getReturnsByProduct(int $productId)
    {
        return SaleReturn::whereHas('products', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->get();
    }

    public function createReturn(array $datas)
    {
        return SaleReturn::create($datas);
    }

    public function updateReturn(int $id, array $data)
    {
        $return = SaleReturn::find($id);
        if ($return) {
            $return->update($data);
            return $return;
        }
        return null;
    }

    public function deleteReturn(int $id)
    {
        $return = SaleReturn::find($id);
        if ($return) {
            return $return->delete();
        }
        return false;
    }

    public function getSaleReturnsByPeriod(
        int $userId,
        string $startDate,
        string $startTime,
        string $closingDate,
        string $closingTime
    ) {
        $start = Carbon::parse("{$startDate} {$startTime}");
        $end = Carbon::parse("{$closingDate} {$closingTime}");

        return SaleReturn::query()
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('
            COUNT(*) AS quantity_returns,
            COALESCE(SUM(total), 0) AS total_returns,
            COALESCE(SUM(cost), 0) AS cost_returns
        ')
            ->first();
    }
}
