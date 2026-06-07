<?php
namespace App\DTOs;

class CustomerDTO
{
    public function __construct(


        public readonly string $full_name,
        public readonly string $identification_card,
        public readonly string $phone,
        public readonly string $email,
        public readonly string $address,
        public readonly int $credit_amount,
        public readonly int $departament_id,
        public readonly int $city_id,
        public readonly int $tax_id,
        public readonly int $type_organice_id,
        public readonly int $identity_document_id,
        public readonly int $customer_tribute_id,
   
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            full_name: $request->full_name,
            identification_card: $request->identification_card,
            email: $request->email,
            phone: $request->phone,
            address: $request->address,
            credit_amount: $request->credit_amount,
            departament_id: $request->departament_id,
            city_id: $request->city_id,
            tax_id: $request->tax_id,
            type_organice_id: $request->type_organice_id,
            identity_document_id: $request->identity_document_id,
            customer_tribute_id: $request->customer_tribute_id
        );
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->full_name,
            'identification_card' => $this->identification_card,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'credit_amount' => $this->credit_amount,
            'departament_id' => $this->departament_id,
            'city_id' => $this->city_id,
            'tax_id' => $this->tax_id,
            'type_organice_id' => $this->type_organice_id,
            'identity_document_id' => $this->identity_document_id,
            'customer_tribute_id' => $this->customer_tribute_id
        ];
    }
}