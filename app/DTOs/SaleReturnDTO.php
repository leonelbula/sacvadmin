<?php
namespace App\DTOs;
use Illuminate\Support\Facades\Auth;

class SaleReturnDTO
{
    public function __construct(
        public readonly int $customer_id,
        public readonly int $user_id,
        public readonly int $cost,
        public readonly int $total,
        public readonly string $reason,
        public readonly string $refund_type,
        public readonly string $state,
        public readonly string|null $observation,
    ) {}

    public static function fromRequest($request): self
    {

        return new self(

            customer_id: (int)$request->input('customer_id', 1),
            user_id:  Auth::id(),
            cost: (int)$request->input('cost', 0),
            total: (int)$request->input('total', 0),
            reason: $request->input('reason', ''),
            refund_type: $request->input('refund_type', ''),
            state: $request->input('state', 'completed'),
            observation: $request->input('observation', 'Sin Observaciones'),
        );
    }

    public function toArray(): array
    {
        return [

            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'cost' => $this->cost,
            'total' => $this->total,
            'reason' => $this->reason,
            'refund_type' => $this->refund_type,
            'state' => $this->state,
            'observation' => $this->observation,
        ];
    }
}
