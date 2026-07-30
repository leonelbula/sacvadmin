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
        public readonly string $department,
        public readonly string $city,      
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
            department: $request->department,
            city: $request->city,
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
            'department' => $this->department,
            'city' => $this->city,
            'state' => $this->state,
          
        ];
    }
}