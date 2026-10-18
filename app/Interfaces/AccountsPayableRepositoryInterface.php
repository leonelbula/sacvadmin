<?php

namespace App\Interfaces;

use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountsPayableRepositoryInterface
{
    public function getAccountsReceivable(
        array $filters = [],
        int $perPage = 15
    ): LengthAwarePaginator;

    public function getTotalReceivable(
        array $filters = []
    ): float;

    public function getPendingAccountsCount(
        array $filters = []
    ): int;

    public function getCustomersWithDebtCount(
        array $filters = []
    ): int;

    public function findAccount(int $id): Shopping;
}
