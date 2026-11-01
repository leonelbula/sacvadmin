<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\AccountReceivablePaymentRepositoryInterface;
use App\Models\AccountReceivablePayment;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AccountReceivablePaymentRepository implements AccountReceivablePaymentRepositoryInterface
{
    public function getPayments(int $saleId, int $perPage = 10): LengthAwarePaginator
    {
        return AccountReceivablePayment::query()
            ->with('user')
            ->where('sale_id', $saleId)
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findSaleForUpdate(int $saleId): Sale
    {
        return Sale::query()
            ->whereKey($saleId)
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function createPayment(array $data): AccountReceivablePayment
    {


        $sale = Sale::query()
            ->whereKey($data['sale_id'])
            ->lockForUpdate()
            ->firstOrFail();

        $payment = AccountReceivablePayment::create($data);
        return $payment;
    }

    public function UpdatePayments(int $paymentId, array $data): AccountReceivablePayment
    {

        $payment = AccountReceivablePayment::query()
            ->whereKey($paymentId)
            ->firstOrFail();

        $oldAmount = (int) $payment->amount;


        $sale = Sale::query()
            ->whereKey($payment->sale_id)
            ->lockForUpdate()
            ->firstOrFail();


        $payment = AccountReceivablePayment::query()
            ->where('sale_id', $payment->sale_id)
            ->whereKey($paymentId)
            ->lockForUpdate()
            ->firstOrFail();

        $newAmount = isset($data['amount']) ? (int) $data['amount'] : $oldAmount;


        $payment->update([
            'amount' => $newAmount,
            'payment_date' => $data['payment_date'] ?? $payment->payment_date,
            'payment_method' => $data['payment_method'] ?? $payment->payment_method,
            'reference' => $data['reference'] ?? $payment->reference,
            'observation' => $data['observation'] ?? $payment->observation,
        ]);

        return $payment;
    }

    public function updateSaleBalance(Sale $sale, int $amount): void
    {
        $sale->balance = round((int) $sale->balance + $amount, 0);
        $sale->save();
    }

    public function findSale(int $saleId): Sale
    {
        return Sale::with('customer')->findOrFail($saleId);
    }

    public function findPayment(int $saleId, int $paymentId): AccountReceivablePayment
    {
        return AccountReceivablePayment::with([
            'sale.customer',
            'user',
        ])
            ->where('sale_id', $saleId)
            ->whereKey($paymentId)
            ->firstOrFail();
    }

    public function deletePayment(int $paymentId): void
    {
        $payment = AccountReceivablePayment::query()
            ->whereKey($paymentId)
            ->firstOrFail();

        $sale = Sale::query()
            ->whereKey($payment->sale_id)
            ->lockForUpdate()
            ->firstOrFail();

        // Ajustamos el balance de la venta antes de eliminar el pago
        $this->updateSaleBalance($sale, (int) $payment->amount);

        $payment->delete();
    }

    public function findPaymentWithoutRelations(int $paymentId): AccountReceivablePayment
    {
        return AccountReceivablePayment::query()
            ->whereKey($paymentId)
            ->firstOrFail();
    }
}
