<?php
namespace App\DTOs;

class CustomerDTO
{
    public function __construct(


        public readonly string $full_name,
        public readonly string $identification,
        public readonly string $phone,
        public readonly string $email,
        public readonly string $address,
        public readonly int $credit_amount,
        public readonly int $departament_id,
        public readonly int $city_id,
        public readonly int $customer_tribute_id,
        public readonly int $identification_document_id,
        public readonly string $responsibilities,
        public readonly int $organization_type_id,
        public readonly bool $state,
   
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            full_name: $request->full_name,
            identification: $request->identification,
            email: $request->email,
            phone: $request->phone,
            address: $request->address,
            credit_amount: $request->credit_amount,
            departament_id: $request->departament_id,
            city_id: $request->city_id,
            customer_tribute_id: $request->customer_tribute_id,
            identification_document_id: $request->identification_document_id,
            responsibilities: $request->responsibilities,
            organization_type_id: $request->organization_type_id,
            state: $request->state,
          
        );
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->full_name,
            'identification' => $this->identification,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'credit_amount' => $this->credit_amount,
            'departament_id' => $this->departament_id,
            'city_id' => $this->city_id,
            'customer_tribute_id' => $this->customer_tribute_id,
            'identification_document_id' => $this->identification_document_id,
            'responsibilities' => $this->responsibilities,
            'organization_type_id' => $this->organization_type_id,
            'state' => $this->state,
          
        ];
    }
}