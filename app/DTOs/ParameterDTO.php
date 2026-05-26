<?php 
namespace App\DTOs;


class ParameterDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $sale_code,
        public readonly bool $tax_included,
        public readonly int $product_code,
        public readonly bool $automatic_product,
        public readonly int $company_id,
    )
    {}

    public static function fromRequest($data): self
    {
        return new self(
            id: $data['id'] ?? 0,
            sale_code: $data['sale_code'] ?? 0,
            tax_included: $data['tax_included'] ?? true,
            product_code: $data['product_code'] ?? 1,
            automatic_product: $data['automatic_product'] ?? true,
            company_id: $data['company_id'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sale_code' => $this->sale_code,
            'tax_included' => $this->tax_included,
            'product_code' => $this->product_code,
            'automatic_product' => $this->automatic_product,
            'company_id' => $this->company_id
        ];
    }
}