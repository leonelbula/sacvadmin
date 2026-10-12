<?php

namespace App\Repositories;

use App\Interfaces\AccountReceivablePaymentRepositoryInterface;
use App\Models\AccountReceivablePayment;
use App\Models\Sale;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AccountReceivablePaymentRepository implements AccountReceivablePaymentRepositoryInterface
{
    public function getPayments(
        int $saleId,
        int $perPage = 15
    ): LengthAwarePaginator {
        return AccountReceivablePayment::query()
            ->with('user')
            ->where('sale_id', $saleId)
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function findSaleForUpdate(int $saleId): Sale
    {
        return Sale::query()
            ->whereKey($saleId)
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function createPayment(
        array $data
    ): AccountReceivablePayment {
        return AccountReceivablePayment::create($data);
    }

    public function updateSaleBalance(
        Sale $sale,
        float $amount
    ): void {
        $sale->balance = round(
            (float) $sale->balance - $amount,
            2
        );

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
}
