<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class SaleDTO
{
    public function __construct(
        public readonly int $sale_number,
        public readonly int $cost,
        public readonly int $utility,
        public readonly int $subtotal,
        public readonly int $total,
        public readonly int $balance,
        public readonly string $hour,
        public readonly string $date_sale,
        public readonly string $term,
        public readonly ?string $expiration_date,
        public readonly string $payment_form,
        public readonly int $payment_method_id, // Corregido a int
        public readonly ?string $observation,   // Permitir null si viene vacío
        public readonly int $taxes,
        public readonly int $customer_id,
        public readonly int $user_id,
        public readonly string $state
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            sale_number: (int)$request->input('sale_number'),
            cost: (int)$request->input('cost',),
            utility: (int)$request->input('utility'),
            subtotal: (int)$request->input('subtotal'),
            total: (int)$request->input('total'),
            balance: (int)$request->input('balance'),
            hour: $request->input('hour', ''),
            date_sale: $request->input('date_sale', ''),
            term: $request->input('term', ''),
            expiration_date: $request->input('expiration_date', ''),
            payment_form: $request->input('payment_form', ''),
            payment_method_id: (int)$request->input('payment_method_id', 0), // Casteo explícito
            observation: $request->observation ?? 'Sin Observaciones',
            taxes: (int)$request->input('tax'),
            customer_id: (int)$request->input('customer_id', 1),
            user_id: Auth::id(), // Forma más limpia de obtener el ID
            state: $request->state ?? 'pending' // Valor por defecto si no viene
        );
    }
    public function toArray(): array
    {
        return [
            'sale_number' => $this->sale_number,
            'cost' => $this->cost,
            'utility' => $this->utility,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'balance' => $this->balance,
            'hour' => $this->hour,
            'date_sale' => $this->date_sale,
            'term' => $this->term,
            'expiration_date' => $this->expiration_date,
            'payment_form' => $this->payment_form,
            'payment_method_id' => $this->payment_method_id,
            'observation' => $this->observation,
            'taxes' => $this->taxes,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'state' => $this->state
        ];
    }
}
