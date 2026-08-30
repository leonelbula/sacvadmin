<?php

namespace App\Interfaces;

use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseRepositoryInterface
{
    /**
     * Obtener todos los gastos paginados.
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator;

    /**
     * Buscar gastos.
     */
    public function search(
        ?string $search = null,
        ?int $typeExpenseId = null,
        ?int $paymentMethodId = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        int $perPage = 10
    ): LengthAwarePaginator;
    /**
     * Obtener un gasto por su ID.
     */
    public function findById(int $id): ?Expense;

    /**
     * Crear un nuevo gasto.
     */
    public function create(array $data): Expense;

    /**
     * Actualizar un gasto.
     */
    public function update(int $id, array $data): Expense;

    /**
     * Eliminar un gasto.
     */
    public function delete(int $id): bool;

    /**
     * Obtener el total de gastos.
     */
    public function getTotal(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): float;

    /**
     * Obtener cantidad de gastos.
     */
    public function getCount(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): int;
}
