<?php

namespace App\Interfaces;

use App\Models\AccountReceivablePayment;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountReceivablePaymentRepositoryInterface
{
    public function getPayments(
        int $saleId,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findSaleForUpdate(int $saleId): Sale;

    public function createPayment(
        array $data
    ): AccountReceivablePayment;

    public function updateSaleBalance(
        Sale $sale,
        float $amount
    ): void;

    public function findSale(int $saleId): Sale;

    public function findPayment(int $saleId, int $paymentId): AccountReceivablePayment;
}
