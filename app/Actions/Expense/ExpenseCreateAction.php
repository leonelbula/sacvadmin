<?php

namespace App\Actions\Expense;

use App\DTOs\ExpenseDTO;
use App\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseCreateAction
{
    public function __construct(
        private ExpenseRepositoryInterface $expenseRepository
    ) {
    }

    public function execute(ExpenseDTO $dto): Expense
    {
        return DB::transaction(function () use ($dto) {

            return $this->expenseRepository->create(
                $dto->toArray()
            );

        });
    }
}

