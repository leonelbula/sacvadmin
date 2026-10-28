<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        private readonly ?string $fechaDesde = null,
        private readonly ?string $fechaHasta = null,
    ) {}

    public function query(): Builder
    {
        return Sale::query()
            ->select([
                'id',
                'sale_number',
                'date_sale',
                'customer_id',
                'user_id',
                'subtotal',
                'total',
                'balance',
            ])
            ->with([
                'customer:id,full_name',
                'user:id,name',
            ])
            ->when(
                $this->fechaDesde,
                fn(Builder $query) => $query->whereDate(
                    'date_sale',
                    '>=',
                    $this->fechaDesde
                )
            )
            ->when(
                $this->fechaHasta,
                fn(Builder $query) => $query->whereDate(
                    'date_sale',
                    '<=',
                    $this->fechaHasta
                )
            )
            ->orderByDesc('date_sale');
    }

    public function headings(): array
    {
        return [
            'Número de factura',
            'Fecha de venta',
            'Cliente',
            'Usuario',
            'Subtotal',
            'Total',
            'Saldo pendiente',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->sale_number,
            $sale->date_sale,
            $sale->customer?->full_name ?? 'Sin cliente',
            $sale->user?->name ?? 'Sin usuario',
            $sale->subtotal,
            $sale->total,
            $sale->balance,
        ];
    }
}
