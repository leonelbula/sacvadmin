<?php

namespace App\Interfaces;

use App\Models\AcountPayablePayment;
use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountPayablePaymentRepositoryInterface
{
    public function getPayments(
        int $shoppig_iId,
        int $perPage = 15
    ): LengthAwarePaginator;

    public function findShoppingForUpdate(int $shopping_Id): Shopping;

    public function createPayment(
        array $data
    ): AcountPayablePayment;

    public function updateShoppingBalance(
        Shopping $shopping,
        float $amount
    ): void;

    public function findShopping(int $shopping_Id): Shopping;

    public function findPayment(int $shopping_Id, int $paymentId): AcountPayablePayment;
}
