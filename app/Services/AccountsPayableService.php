<?php

namespace App\Services;

use App\Interfaces\AccountsPayableRepositoryInterface;
use App\Models\Shopping;

class AccountsPayableService
{
    public function __construct(
        private AccountsPayableRepositoryInterface $repository
    ) {}

    public function getAccountsReceivable(
        array $filters = [],
        int $perPage = 15
    ): array {
        return [
            'cuentas' => $this->repository->getAccountsReceivable(
                $filters,
                $perPage
            ),

            'totalPorPagar' => $this->repository->getTotalReceivable(
                $filters
            ),

            'cantidadCuentas' => $this->repository->getPendingAccountsCount(
                $filters
            ),

            'cantidadProveedores' => $this->repository->getCustomersWithDebtCount(
                $filters
            ),
        ];
    }

    public function findAccount(int $id): Shopping
    {
        return $this->repository->findAccount($id);
    }


}
