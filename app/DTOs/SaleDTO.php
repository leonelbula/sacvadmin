<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class SaleDTO
{
    public function __construct(
        public readonly int $sale_number,
        public readonly float $cost,
        public readonly float $utility,
        public readonly float $subtotal,
        public readonly float $total_iva,
        public readonly float $total,
        public readonly float $balance,
        public readonly string $hour,
        public readonly string $date_sale,
        public readonly string $term,
        public readonly string $expiration_date,
        public readonly string $type_sale,
        public readonly string $payment_form,
        public readonly string $payment_method,
        public readonly int $customer_id,
        public readonly int $user_id
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            sale_number: $request->input('sale_number', 0),
            cost: $request->input('cost', 0),
            utility: $request->input('utility', 0),
            subtotal: $request->input('subtotal', 0),
            total_iva: $request->input('total_iva', 0),
            total: $request->input('total', 0),
            balance: $request->input('balance', 0),
            hour: $request->input('hour', ''),
            date_sale: $request->input('date_sale', ''),
            term: $request->input('term', ''),
            expiration_date: $request->input('expiration_date', ''),
            type_sale: $request->input('type_sale', ''),
            payment_form: $request->input('payment_form', ''),
            payment_method: $request->input('payment_method', ''),
            customer_id: $request->input('customer_id', 0),
            user_id: Auth::user()->id
        );
    }
    public function toArray(): array
    {
        return [
            'sale_number' => $this->sale_number,
            'cost' => $this->cost,
            'utility' => $this->utility,
            'subtotal' => $this->subtotal,
            'total_iva' => $this->total_iva,
            'total' => $this->total,
            'balance' => $this->balance,
            'hour' => $this->hour,
            'date_sale' => $this->date_sale,
            'term' => $this->term,
            'expiration_date' => $this->expiration_date,
            'type_sale' => $this->type_sale,
            'payment_form' => $this->payment_form,
            'payment_method' => $this->payment_method,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id
        ];
    }
}
