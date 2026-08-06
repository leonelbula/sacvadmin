<?php

namespace App\DTOs;


class ProductDTO
{

    public function __construct(
        public readonly ?string $code,
        public readonly string $name,
        public readonly int $cost,
        public readonly int $price,
        public readonly int $utility,
        public readonly int $stock_min,
        public readonly int $stock,       
        public readonly bool $state,    
        public readonly int $tax_id,  
        public readonly int $category_id
    ) {}

    public static function fromRequest($request): self
    {

        
        return new self(
            code: $request->code,
            name: $request->name,
            cost: $request->cost,
            price: $request->price,
            utility: $request->utility,
            stock_min: (int) $request->stock_min,
            stock: (int) $request->stock,           
            state: $request->state,          
            tax_id: (int) $request->tax_id,
            category_id: (int) $request->category_id
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
            'stock_min' => $this->stock_min,
            'stock' => $this->stock,            
            'state' => $this->state,            
            'tax_id' => $this->tax_id,
            'category_id' => $this->category_id
        ];
    }
}
