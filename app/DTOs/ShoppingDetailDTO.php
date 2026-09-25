<?php
namespace App\DTOs;

class SaleDetailDTO
{
    public function __construct(

        public readonly int $shopping_id,
        public readonly int $product_id,
        public readonly float $price,
        public readonly bool $has_iva,
        public readonly int $quantity,
        public readonly float $iva,
        public readonly float $subtotal,
        public readonly float $total
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            shopping_id: $request->input('shopping_id', 0),
            product_id: $request->input('product_id', 0),
            quantity: $request->input('quantity', 0),
            price: $request->input('price', 0),
            has_iva : $request->input('has_iva', 1),
            subtotal: $request->input('subtotal', 0),
            iva: $request->input('iva', 0),
            total: $request->input('total', 0)
        );
    }
    public function toArray(): array
    {
        return [
            'shopping_id' => $this->shopping_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'has_iva'=> $this->has_iva,
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'total' => $this->total
        ];
    }
}
