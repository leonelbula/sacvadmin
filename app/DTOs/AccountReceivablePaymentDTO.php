<?php

namespace App\DTOs;

class AccountReceivablePaymentDTO
{
    public function __construct(
        public int $amount,
        public string $payment_date,
        public string $payment_method,
        public ?string $reference = null,
        public ?string $observation = null
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            amount: (int) $request->amount,
            payment_date: $request->payment_date,
            payment_method: $request->payment_method,
            reference: $request->reference ?? null,
            observation: $request->observation ?? 'Sin observaciones'
        );
    }
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'payment_method' => $this->payment_method,
            'reference' => $this->reference,
            'observation' => $this->observation,
        ];
    }
}
