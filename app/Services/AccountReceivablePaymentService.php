<?php

namespace App\Services;

use App\Interfaces\AccountReceivablePaymentRepositoryInterface;
use App\Models\AccountReceivablePayment;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AccountReceivablePaymentService
{
    public function __construct(
        private AccountReceivablePaymentRepositoryInterface $repository
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
        int $saleId,
        array $data,
        int $userId
    ): AccountReceivablePayment {
        return DB::transaction(function () use (
            $saleId,
            $data,
            $userId
        ) {
            $sale = $this->repository->findSaleForUpdate($saleId);

            $amount = round((float) $data['amount'], 2);
            $balance = round((float) $sale->balance, 2);

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
                'sale_id' => $sale->id,
                'user_id' => $userId,
                'amount' => $amount,
                'payment_date' => $data['payment_date'],
                'payment_method' => $data['payment_method'],
                'reference' => $data['reference'] ?? null,
                'observation' => $data['observation'] ?? null,
            ]);

            $this->repository->updateSaleBalance(
                $sale,
                $amount
            );

            return $payment;
        }, 3);
    }

    public function findSale(int $saleId): Sale
    {
        return $this->repository->findSale($saleId);
    }

    public function findPayment(int $saleId, int $paymentId): AccountReceivablePayment
    {
        return $this->repository->findPayment($saleId, $paymentId);
    }
}
