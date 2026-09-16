<?php

namespace App\Repositories;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class SaleRepository implements SaleRepositoryInterface
{
    public function All(): LengthAwarePaginator
    {
        return Sale::orderBy('id', 'desc')->paginate(10);
    }

    public function findById(int $id): Sale
    {
        return Sale::findOrFail($id);
    }

    public function create(array $data): Sale
    {
        return Sale::create($data);
    }

    public function update(int $id, array $data): Sale
    {
        $sale = $this->findById($id);
        $sale->update($data);
        return $sale;
    }

    public function delete(int $id): bool
    {
        $sale = $this->findById($id);

        if (!$sale) {
            return false;
        }

        return (bool) $sale->delete();
    }



    public function lastSale(): ?Sale
    {
        return Sale::latest('id')->first();
    }

    public function totalSale() {}
    public function totalSaleDate(string $start_date, string $close_date) {}


    public function getSalesByPeriod(
        int $userId,
        string $startDate,
        string $startTime,
        string $closingDate,
        string $closingTime
    ) {
        $start = Carbon::parse(
            "{$startDate} {$startTime}"
        );

        $end = Carbon::parse(
            "{$closingDate} {$closingTime}"
        );

        return Sale::query()
            ->where('user_id', $userId)

            ->where(function ($query) use ($start, $end) {

                /*
                |--------------------------------------------------------------------------
                | MISMO DÍA
                |--------------------------------------------------------------------------
                */
                if ($start->toDateString() === $end->toDateString()) {

                    $query->whereDate(
                        'date_sale',
                        $start->toDateString()
                    )
                        ->whereTime(
                            'hour',
                            '>=',
                            $start->format('H:i:s')
                        )
                        ->whereTime(
                            'hour',
                            '<=',
                            $end->format('H:i:s')
                        );

                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | DÍA DE APERTURA
                |--------------------------------------------------------------------------
                */
                $query->where(function ($q) use ($start) {

                    $q->whereDate(
                        'date_sale',
                        $start->toDateString()
                    )
                        ->whereTime(
                            'hour',
                            '>=',
                            $start->format('H:i:s')
                        );
                });

                /*
                |--------------------------------------------------------------------------
                | DÍAS INTERMEDIOS
                |--------------------------------------------------------------------------
                */
                $query->orWhere(function ($q) use ($start, $end) {

                    $q->whereDate(
                        'date_sale',
                        '>',
                        $start->toDateString()
                    )
                        ->whereDate(
                            'date_sale',
                            '<',
                            $end->toDateString()
                        );
                });

                /*
                |--------------------------------------------------------------------------
                | DÍA DE CIERRE
                |--------------------------------------------------------------------------
                */
                $query->orWhere(function ($q) use ($end) {

                    $q->whereDate(
                        'date_sale',
                        $end->toDateString()
                    )
                        ->whereTime(
                            'hour',
                            '<=',
                            $end->format('H:i:s')
                        );
                });
            })

            ->selectRaw('
                payment_method_id,
                COUNT(*) AS quantity,
                COALESCE(SUM(total), 0) AS total
            ')

            ->groupBy('payment_method_id')

            ->with('paymentMethod')

            ->get();
    }
    public function searchSales(array $filters): LengthAwarePaginator
    {
        return Sale::query()
            ->with(['customer', 'paymentMethod'])

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
            ->when($filters['sale_number'] ?? null, function ($query, $saleNumber) {
                $query->where('sale_number', $saleNumber);
            })

            // Forma de pago
            ->when(
                isset($filters['payment_form']) &&
                    $filters['payment_form'] !== 'all',
                function ($query) use ($filters) {
                    $query->where(
                        'payment_form',
                        $filters['payment_form']
                    );
                }
            )

            // Fecha inicial
            ->when($filters['date_from'] ?? null, function ($query, $dateFrom) {
                $query->whereDate('date_sale', '>=', $dateFrom);
            })

            // Fecha final
            ->when($filters['date_to'] ?? null, function ($query, $dateTo) {
                $query->whereDate('date_sale', '<=', $dateTo);
            })

            ->orderByDesc('date_sale')
            ->orderByDesc('hour')
            ->paginate(10);
    }
    public function findBySaleNumber(int $saleNumber)
    {
        return Sale::with([
            'customer',
            'details.product'
        ])
            ->where('sale_number', $saleNumber)
            ->first();
    }
}
