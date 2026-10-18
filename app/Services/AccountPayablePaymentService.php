<?php

namespace App\Services;

use App\Interfaces\AccountPayablePaymentRepositoryInterface;
use App\Models\AcountPayablePayment;
use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AccountPayablePaymentService
{
    public function __construct(
        private AccountPayablePaymentRepositoryInterface $repository
    ) {}

    public function getPayments(
        int $saleId,
        int $perPage = 15
    ): LengthAwarePaginator {
        return $this->repository->getPayments(
            $saleId,
            $perPage
        );
    }

    public function registerPayment(
        int $shopping,
        array $data,
        int $userId
    ): AcountPayablePayment {
        return DB::transaction(function () use (
            $shopping,
            $data,
            $userId
        ) {
            $shopping = $this->repository->findShoppingForUpdate($shopping);

            $amount = round((float) $data['amount'], 2);
            $balance = round((float) $shopping->balance, 2);

            if ($balance <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Esta cuenta ya está pagada.',
                ]);
            }

            if ($amount <= 0 || $amount > $balance) {
                throw ValidationException::withMessages([
                    'amount' => 'El abono debe ser mayor que cero y no puede superar el saldo pendiente de la factura.',
                ]);
            }

            $payment = $this->repository->createPayment([
                'shopping_id' => $shopping->id,
                'user_id' => $userId,
                'amount' => $amount,
                'payment_date' => $data['payment_date'],
                'payment_method' => $data['payment_method'],
                'reference' => $data['reference'] ?? null,
                'observation' => $data['observation'] ?? null,
            ]);

            $this->repository->updateShoppingBalance(
                $shopping,
                $amount
            );

            return $payment;
        }, 3);
    }

    public function findShopping(int $shopping_id): Shopping
    {
        return $this->repository->findShopping($shopping_id);
    }

    public function findPayment(int $shopping_id, int $paymentId): AcountPayablePayment
    {
        return $this->repository->findPayment($shopping_id, $paymentId);
    }
}
