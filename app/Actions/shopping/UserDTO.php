<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $type,
        public readonly bool $state,
        public readonly ?string $password = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->string('name')->toString(),
            email: $request->string('email')->toString(),
            type: $request->string('type')->toString(),
            state: $request->boolean('state'),
            password: $request->filled('password')
                ? $request->string('password')->toString()
                : null,
        );
    }
}
