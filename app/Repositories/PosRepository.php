<?php

namespace App\Repositories;

use App\Interfaces\PosRepositoryInterface;
use App\Models\Pos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PosRepository implements PosRepositoryInterface
{
    public function All(): array
    {
        $pos = Pos::orderBy('id', 'desc')
            ->paginate(10);

        return [
            'pos' => $pos,
            'totalSale' => Pos::sum('total_sale'),
            'totalCash' => Pos::sum('cash'),
            'totalDifferenceNegative' => Pos::where('difference', '<', 0)
                ->sum('difference'),
            'totalDifferencePositive' => Pos::where('difference', '>', 0)
                ->selectRaw('ABS(SUM(difference)) as total')
                ->value('total'),
        ];
    }
    public function search(
        ?int $userId = null,
        ?string $startDate = null,
        ?string $endDate = null,
        ?string $difference = null
    ): array {
        $baseQuery = Pos::query();

        if ($userId !== null) {
            $baseQuery->where('user_id', $userId);
        }

        if ($startDate !== null && $endDate !== null) {
            $baseQuery->whereBetween('start_date', [
                $startDate,
                $endDate
            ]);
        } elseif ($startDate !== null) {
            $baseQuery->whereDate('start_date', '>=', $startDate);
        } elseif ($endDate !== null) {
            $baseQuery->whereDate('start_date', '<=', $endDate);
        }

        $query = clone $baseQuery;

        if ($difference === 'negative') {
            $query->where('difference', '<', 0);
        }

        if ($difference === 'positive') {
            $query->where('difference', '>', 0);
        }

        if ($difference === 'zero') {
            $query->where('difference', '=', 0);
        }

        return [
            'pos' => $query
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString(),

            'totalSale' => (clone $baseQuery)
                ->sum('total_sale'),

            'totalCash' => (clone $baseQuery)
                ->sum('cash'),

            'totalDifferencePositive' => (clone $baseQuery)
                ->where('difference', '>', 0)
                ->sum('difference'),

            'totalDifferenceNegative' => abs(
                (clone $baseQuery)
                    ->where('difference', '<', 0)
                    ->sum('difference')
            ),

            'totalDifferenceZero' => (clone $baseQuery)
                ->where('difference', '=', 0)
                ->count(),
        ];
    }
    public function findById(int $id): Pos
    {
        // Lanza ModelNotFoundException (404) si no existe
        return Pos::findOrFail($id);
    }

    public function create(array $data): Pos
    {
        return Pos::create($data);
    }

    public function update(int $id, array $data): Pos
    {
        $pos = $this->findById($id);
        $pos->update($data);
        return $pos;
    }

    public function delete(int $id): bool
    {
        // Al usar findById, si no existe ya lanza la excepción automáticamente
        $pos = $this->findById($id);

        return (bool) $pos->delete();
    }

    public function lastPos(): ?Pos
    {
        return Pos::latest('id')->first();
    }

    // Corregido: Se agrega el "?" porque si el usuario no tiene cajas, devolverá null
    public function posActive(int $idUser): ?Pos
    {
        return Pos::where('user_id', $idUser)->latest()->first();
    }
}
