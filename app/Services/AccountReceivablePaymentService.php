<?php

namespace App\Services;

use App\DTOs\AccountReceivablePaymentDTO;
use App\Repositories\Contracts\AccountReceivablePaymentRepositoryInterface;
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

    public function getPayments(int $saleId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getPayments($saleId, $perPage);
    }

    public function registerPayment(int $saleId, AccountReceivablePaymentDTO $dto, int $userId): AccountReceivablePayment
    {
        return DB::transaction(function () use ($saleId, $dto, $userId) {


            $sale = $this->repository->findSaleForUpdate($saleId);

            $amount = round((int) $dto->amount, 0);
            $balance = round((int) $sale->balance, 0);

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
                'payment_date' => $dto->payment_date,
                'payment_method' => $dto->payment_method,
                'reference' => $dto->reference ?? null,
                'observation' => $dto->observation ?? null,
            ]);


            $this->repository->updateSaleBalance($sale, -$amount);

            return $payment;
        }, 3);
    }

    public function updatePayment(int $paymentId, AccountReceivablePaymentDTO $dto): AccountReceivablePayment
    {
        return DB::transaction(function () use ($paymentId, $dto) {


            $payment = $this->repository->findPaymentWithoutRelations($paymentId); // O findPayment si creas el método
            $oldAmount = (int) $payment->amount;
            $newAmount = (int) $dto->amount;


            $sale = $this->repository->findSaleForUpdate($payment->sale_id);

            $maxAllowed = round($sale->balance + $oldAmount, 0);

            if ($newAmount <= 0 || $newAmount > $maxAllowed) {
                throw ValidationException::withMessages([
                    'amount' => "El monto del abono no puede superar el saldo disponible de la venta (Máximo permitido: {$maxAllowed}).",
                ]);
            }

            $updatedPayment = $this->repository->UpdatePayments($paymentId, [
                'amount' => $newAmount,
                'payment_date' => $dto->payment_date,
                'payment_method' => $dto->payment_method,
                'reference' => $dto->reference ?? null,
                'observation' => $dto->observation ?? null,
            ]);

            $difference = $newAmount - $oldAmount;
            if ($difference !== 0) {
                $this->repository->updateSaleBalance($sale, -$difference);
            }

            return $updatedPayment;
        }, 3);
    }

    public function findPaymentWithoutRelations(int $paymentId): AccountReceivablePayment
    {
        return $this->repository->findPaymentWithoutRelations($paymentId);
    }
    public function findSale(int $saleId): Sale
    {
        return $this->repository->findSale($saleId);
    }

    public function findPayment(int $saleId, int $paymentId): AccountReceivablePayment
    {
        return $this->repository->findPayment($saleId, $paymentId);
    }

    public function deletePayment(int $paymentId): void
    {
        DB::transaction(function () use ($paymentId) {
            $this->repository->deletePayment($paymentId);
        }, 3);
    }
}
