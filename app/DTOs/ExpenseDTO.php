<?php

namespace App\DTOs;

use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseDTO
{
    public function __construct(
        public readonly string $description,
        public readonly int $total,
        public readonly string $date,
        public readonly string $delivered_to,
        public readonly string $hour,
        public readonly ?string $observation,
        public readonly int $payment_method_id,
        public readonly int $type_expense_id,
        public readonly int $user_id,
    ) {
    }

    public static function fromRequest(ExpenseRequest $request): self
    {
        return new self(
            description: $request->description,
            total: (int) $request->total,
            date: $request->date,
            delivered_to: $request->delivered_to,
            hour: $request->hour,
            observation: $request->observation,
            payment_method_id: (int) $request->payment_method_id,
            type_expense_id: (int) $request->type_expense_id,
            user_id: (int) Auth::id(),
        );
    }

    public function toArray(): array
    {
        return [
            'description'       => $this->description,
            'total'             => $this->total,
            'date'              => $this->date,
            'delivered_to'      => $this->delivered_to,
            'hour'              => $this->hour,
            'observation'       => $this->observation,
            'payment_method_id' => $this->payment_method_id,
            'type_expense_id'   => $this->type_expense_id,
            'user_id'           => $this->user_id,
        ];
    }
}

