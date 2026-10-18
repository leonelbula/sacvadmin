<?php

namespace App\Repositories;

use App\Interfaces\AccountPayablePaymentRepositoryInterface;
use App\Models\AcountPayablePayment;
use App\Models\Shopping;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AcountPayablePaymentRepository implements AccountPayablePaymentRepositoryInterface

{
    public function getPayments(
        int $shopping_id,
        int $perPage = 15
    ): LengthAwarePaginator {
        return AcountPayablePayment::query()
            ->with('user')
            ->where('shopping_id', $shopping_id)
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function findShoppingForUpdate(int $shopping_Id): Shopping
    {
        return Shopping::query()
            ->whereKey($shopping_Id)
            ->lockForUpdate()
            ->firstOrFail();
    }

    public function createPayment(
        array $data
    ): AcountPayablePayment {
        return AcountPayablePayment::create($data);
    }

    public function updateShoppingBalance(
        Shopping $sale,
        float $amount
    ): void {
        $sale->balance = round(
            (float) $sale->balance - $amount,
            2
        );

        $sale->save();
    }
    public function findShopping(int $shopping_Id): Shopping
    {
        return Shopping::with('supplier')->findOrFail($shopping_Id);
    }
    public function findPayment(int $shooping_Id, int $paymentId): AcountPayablePayment
    {
        return AcountPayablePayment::with([
            'shopping.supplier',
            'user',
        ])
            ->where('shopping_id', $shooping_Id)
            ->whereKey($paymentId)
            ->firstOrFail();
    }
}
