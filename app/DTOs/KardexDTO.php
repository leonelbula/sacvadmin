<?php
namespace App\DTOs;

class KardexDTO
{
    public function __construct(
       
        public \DateTime $date,
        public string $movement_type,
        public string $origin,
        public int $reference_id,
        public int $income,
        public int $output,
        public int $stock_before,
        public int $stock_after,
        public int $unit_cost,
        public int $product_id,
        public string $user_name,



    ) {}


    public static function fromRequest($data): self
    {
        return new self(
            product_id: $data['product_id'],
            date: now(),
            movement_type: $data['movement_type'],
            origin: $data['origin'],
            reference_id: $data['reference_id'],
            income: $data['income'],
            output: $data['output'],
            stock_before: $data['stock_before'],
            stock_after: $data['stock_after'],
            unit_cost: $data['unit_cost'],
            user_name: $data['user_name'],
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
            'income' => $this->income,
            'output' => $this->output,
            'stock_before' => $this->stock_before,
            'stock_after' => $this->stock_after,
            'unit_cost' => $this->unit_cost,
            'user_name' => $this->user_name
        ];
    }
}