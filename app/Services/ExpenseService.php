<?php

namespace App\Services;

use App\Actions\Expense\ExpenseCreateAction;
use App\DTOs\ExpenseDTO;
use App\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseService
{
    public function __construct(
        private ExpenseRepositoryInterface $expenseRepository,
        private ExpenseCreateAction $expenseCreateAction
    ) {}

    /**
     * Obtener todos los gastos.
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->expenseRepository->getAll($perPage);
    }

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
    ): LengthAwarePaginator {

        return $this->expenseRepository->search(
            search: $search,
            typeExpenseId: $typeExpenseId,
            paymentMethodId: $paymentMethodId,
            dateFrom: $dateFrom,
            dateTo: $dateTo,
            perPage: $perPage
        );
    }

    /**
     * Obtener un gasto.
     */
    public function findById(int $id): ?Expense
    {
        return $this->expenseRepository->findById($id);
    }

    /**
     * Crear un gasto.
     */
    public function create(ExpenseDTO $dto): Expense
    {
        return $this->expenseCreateAction->execute($dto);
    }

    /**
     * Actualizar un gasto.
     */
    public function update(int $id, array $data): Expense
    {
        return $this->expenseRepository->update(
            id: $id,
            data: $data
        );
    }

    /**
     * Eliminar un gasto.
     */
    public function delete(int $id): bool
    {
        return $this->expenseRepository->delete($id);
    }

    /**
     * Obtener total de gastos.
     */
    public function getTotal(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): float {

        return $this->expenseRepository->getTotal(
            dateFrom: $dateFrom,
            dateTo: $dateTo
        );
    }

    /**
     * Obtener cantidad de gastos.
     */
    public function getCount(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): int {

        return $this->expenseRepository->getCount(
            dateFrom: $dateFrom,
            dateTo: $dateTo
        );
    }
}
