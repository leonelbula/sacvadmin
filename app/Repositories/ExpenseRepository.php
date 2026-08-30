<?php

namespace App\Repositories;

use App\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Expense::query()
            ->with(['category', 'paymentMethod', 'user'])
            ->latest()
            ->paginate($perPage);
    }

    public function search(
        ?string $search = null,
        ?int $typeExpenseId = null,
        ?int $paymentMethodId = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        int $perPage = 10
    ): LengthAwarePaginator {

        return Expense::query()
            ->with([
                'paymentMethod',
                'typeExpense',
                'user',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query->where('description', 'LIKE', "%{$search}%")
                        ->orWhere('delivered_to', 'LIKE', "%{$search}%");
                });
            })

            ->when($typeExpenseId, function ($query) use ($typeExpenseId) {

                $query->where('type_expense_id', $typeExpenseId);
            })

            ->when($paymentMethodId, function ($query) use ($paymentMethodId) {

                $query->where('payment_method_id', $paymentMethodId);
            })

            ->when($dateFrom, function ($query) use ($dateFrom) {

                $query->whereDate('date', '>=', $dateFrom);
            })

            ->when($dateTo, function ($query) use ($dateTo) {

                $query->whereDate('date', '<=', $dateTo);
            })

            ->latest('date')
            ->paginate($perPage);
    }
    public function findById(int $id): ?Expense
    {
        return Expense::with([
            'typeExpense',
            'paymentMethod',
            'user'
        ])->find($id);
    }

    public function create(array $data): Expense
    {
        return Expense::create($data);
    }

    public function update(int $id, array $data): Expense
    {
        $expense = Expense::findOrFail($id);

        $expense->update($data);

        return $expense->fresh([
            'typeExpense',
            'paymentMethod',
            'user'
        ]);
    }

    public function delete(int $id): bool
    {
        $expense = Expense::findOrFail($id);

        return (bool) $expense->delete();
    }

    public function getTotal(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): float {

        return (float) Expense::query()
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('expense_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('expense_date', '<=', $dateTo);
            })
            ->sum('amount');
    }

    public function getCount(
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): int {

        return Expense::query()
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('expense_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('expense_date', '<=', $dateTo);
            })
            ->count();
    }
}
