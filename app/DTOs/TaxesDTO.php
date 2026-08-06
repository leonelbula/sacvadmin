<?php
namespace App\DTOs;

class TaxesDTO
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $description,
        public float $value,
    ) {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            id: $data['id'],
            code: $data['code'],
            name: $data['name'],
            description: $data['description'],
            value: (int) $data['value'],
        );
    }
    public  function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'value' => $this->value,
        ];
    }
}