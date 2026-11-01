<?php

namespace App\Repositories\Contracts;

use App\Models\AccountReceivablePayment;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountReceivablePaymentRepositoryInterface
{
    public function getPayments(int $saleId, int $perPage = 15): LengthAwarePaginator;

    public function findSaleForUpdate(int $saleId): Sale;

    public function createPayment(array $data): AccountReceivablePayment;

    public function UpdatePayments(int $paymentId, array $data): AccountReceivablePayment;

    public function updateSaleBalance(Sale $sale, int $amount): void;

    public function findSale(int $saleId): Sale;

    public function findPayment(int $saleId, int $paymentId): AccountReceivablePayment;

    public function deletePayment(int $paymentId): void;

    public function findPaymentWithoutRelations(int $paymentId): AccountReceivablePayment;
}
