<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class ShoppingDTO
{
    public function __construct(
        public readonly string $invoice_number,
        public readonly string $shopping_date,
        public readonly ?string $purchase_type,
        public readonly ?int $term,
        public readonly int $subtotal,
        public readonly int $iva,
        public readonly int $total,
        public readonly int $balance,
        public readonly string $due_date,
        public readonly int $supplier_id,
        public readonly ?string $observation,
        public readonly int $user_id,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            invoice_number: $request->input('invoice_number'),
            shopping_date: $request->input('shopping_date',),
            purchase_type: $request->input('purchase_type', 'counted'),
            term: $request->input('term', 0),
            subtotal: (int)$request->input('subtotal'),
            total: (int)$request->input('total'),
            iva: (int)$request->input('tax'),
            balance: (int)$request->input('balance'),
            due_date: $request->input('due_date', ''),
            supplier_id: $request->input('supplier_id', ''),
            observation: $request->observation ?? 'Sin Observaciones',
            user_id: Auth::id() // Forma más limpia de obtener el ID
        );
    }
    public function toArray(): array
    {
        return [
            'invoice_number' => $this->invoice_number,
            'shopping_date' => $this->shopping_date,
            'purchase_type' => $this->purchase_type,
            'term'=> $this->term,
            'subtotal' => $this->subtotal,
            'iva'=>$this->iva,
            'total' => $this->total,
            'balance' => $this->balance,
            'due_date' => $this->due_date,
            'supplier_id' => $this->supplier_id,
            'observation' => $this->observation,
            'user_id' => $this->user_id,
        ];
    }
}
