<?php

namespace App\DTOs;


class ProductDTO
{

    public function __construct(
        public readonly ?string $code,
        public readonly string $name,
        public readonly float $cost,
        public readonly float $price,
        public readonly float $utility,
        public readonly float $minimum_amount,
        public readonly float $amount,
        public readonly bool $tax,
        public readonly int $tax_value,
        public readonly bool $state,
        public readonly int $product_type_id,
        public readonly int $taxes_id,
        public readonly int $category_id
    ) {}

    public static function fromRequest($request): self
    {

        if (intval($request->tax_value) != 0) {
            $tax = true;
        } else {
            $tax = false;
        }
        return new self(
            code: $request->code,
            name: $request->name,
            cost: $request->cost,
            price: $request->price,
            utility: $request->utility,
            minimum_amount: $request->minimum_amount,
            amount: $request->amount,
            tax: $tax,
            tax_value: $request->tax_value,
            state: $request->state,
            product_type_id: $request->product_type_id,
            taxes_id: $request->taxes_id,
            category_id: $request->category_id
        );
    }
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'utility' => $this->utility,
            'minimum_amount' => $this->minimum_amount,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'tax_value' => $this->tax_value,
            'state' => $this->state,
            'product_type_id' => $this->product_type_id,
            'taxes_id' => $this->taxes_id,
            'category_id' => $this->category_id
        ];
    }
}
