<?php
namespace App\DTOs;

class SaleDetailDTO
{
    public function __construct(
       
        public readonly int $sale_id,
        public readonly int $product_id,
        public readonly float $price,
        public readonly float $cost,
        public readonly int $quantity,
        public readonly float $iva,
        public readonly float $subtotal,    
        public readonly float $total
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            sale_id: $request->input('sale_id', 0),
            product_id: $request->input('product_id', 0),
            price: $request->input('price', 0),
            cost: $request->input('cost', 0),
            quantity: $request->input('quantity', 0),
            iva: $request->input('iva', 0),
            subtotal: $request->input('subtotal', 0),
            total: $request->input('total', 0)
        );
    }
    public function toArray(): array
    {
        return [
            'sale_id' => $this->sale_id,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'cost' => $this->cost,
            'quantity' => $this->quantity,
            'iva' => $this->iva,
            'subtotal' => $this->subtotal,
            'total' => $this->total
        ];
    }
}
