<?php

namespace App\Services;

use App\Interfaces\AccountsReceivableRepositoryInterface;
use App\Models\Sale;

class AccountsReceivableService
{
    public function __construct(
        private AccountsReceivableRepositoryInterface $repository
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

            'totalPorCobrar' => $this->repository->getTotalReceivable(
                $filters
            ),

            'cantidadCuentas' => $this->repository->getPendingAccountsCount(
                $filters
            ),

            'cantidadClientes' => $this->repository->getCustomersWithDebtCount(
                $filters
            ),
        ];
    }

    public function findAccount(int $id): Sale
    {
        return $this->repository->findAccount($id);
    }

   
}
