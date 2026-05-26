<?php
namespace App\DTOs;

class KardexDTO
{
    public function __construct(
        public int $product_id,
        public \DateTime $date,
        public string $movement_type,
        public string $origin,
        public int $reference_id,
        public int $quantity,
        public int $stock_before,
        public int $stock_after,
        public int $unit_cost
    ) {}


    public static function fromRequest($data): self
    {
        return new self(
            product_id: $data['product_id'],
            date: now(),
            movement_type: $data['movement_type'],
            origin: $data['origin'],
            reference_id: $data['reference_id'],
            quantity: $data['quantity'],
            stock_before: $data['stock_before'],
            stock_after: $data['stock_after'],
            unit_cost: $data['unit_cost']
        );
    }
    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'date' => $this->date,
            'movement_type' => $this->movement_type,
            'origin' => $this->origin,
            'reference_id' => $this->reference_id,
            'quantity' => $this->quantity,
            'stock_before' => $this->stock_before,
            'stock_after' => $this->stock_after,
            'unit_cost' => $this->unit_cost
        ];
    }
}