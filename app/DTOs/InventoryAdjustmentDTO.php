<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;


class InventoryAdjustmentDTO
{
    public function __construct(
        public readonly int $product_id,
        public readonly string $movement_type,
        public readonly int $quantity,
        public readonly int $stock_before,
        public readonly int $stock_after,
        public readonly ?string $observation,
        public readonly int $user_id,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            product_id: (int) $request->product_id,
            movement_type: $request->movement_type,
            quantity: (int) $request->quantity,
            stock_before: (int) $request->stock_before ?? 0,
            stock_after: (int) $request->stock_after ?? 0,
            observation: $request->observation,
            user_id: (int) Auth::id(),
        );
    }
    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'movement_type' => $this->movement_type,
            'quantity' => $this->quantity,
            'stock_before' => $this->stock_before,
            'stock_after' => $this->stock_after,
            'observation' => $this->observation,
            'user_id' => $this->user_id,
        ];
    }
}
