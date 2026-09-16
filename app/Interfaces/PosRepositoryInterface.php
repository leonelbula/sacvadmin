<?php

namespace App\Interfaces;

use App\Models\Pos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PosRepositoryInterface
{
    public function All(): array;

    public function search(?int $userId = null, ?string $startDate = null, ?string $endDate = null, ?string $difference = null): array;

    public function findById(int $id): Pos;

    public function create(array $data): Pos;

    public function update(int $id, array $data): Pos;

    public function delete(int $id): bool;

    public function lastPos(): ?Pos;

    public function posActive(int $idUser): ?Pos;
}
