<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class PosDTO
{
    public function __construct(
        public readonly int $box_base,
        public readonly int $total_sale,
        public readonly int $difference,
        public readonly string $start_time,
        public readonly string $closing_time,
        public readonly string $start_date,
        public readonly string $closing_date,
        public readonly int $bills,
        public readonly int $consignment,
        public readonly int $cash,
        public readonly int $returns_sale,
        public readonly int $delivered_value,
        public readonly bool $state,
        public readonly int $user_id
    ) {}

    public static function fromRequest($request): self
    {

        return new self(
            box_base: $request->box_base ,
            total_sale: $request->total_sale ?? 0,
            difference: $request->difference ?? 0,
            start_time: $request->start_time ?? now()->format('H:i:s'),
            closing_time: $request->closing_time ?? now()->format('H:i:s'),
            start_date: $request->start_date ??  now()->format('Y-m-d'),
            closing_date: $request->closing_date ?? now()->format('Y-m-d'),
            bills: $request->bills ?? 0,
            consignment: $request->consignment ?? 0,
            cash: $request->cash ?? 0,
            returns_sale: $request->returns_sale ?? 0,
            delivered_value: $request->delivered_value ?? 0,
            state: $request->state ?? 1,
            user_id: Auth::id()
        );
    }
    public function toArray(): array
    {
        return [
            'box_base' => $this->box_base,
            'total_sale' => $this->total_sale,
            'difference' => $this->difference,
            'start_time' => $this->start_time,
            'closing_time' => $this->closing_time,
            'start_date' => $this->start_date,
            'closing_date' => $this->closing_date,
            'bills' => $this->bills,
            'consignment' => $this->consignment,
            'cash' => $this->cash,
            'returns_sale' => $this->returns_sale,
            'delivered_value' => $this->delivered_value,
            'state' => $this->state,
            'user_id' => $this->user_id
        ];
    }
}
