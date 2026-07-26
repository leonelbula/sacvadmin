<?php

namespace App\DTOs;

class CategoryDTO
{


    public function __construct(
        public readonly string $name,
        public readonly int $state,

    ) {}
    public static function fromRequest($request): self
    {
        /*if ($request->input('state') == 'on') {
            $state = 1;
        } else {
            $state = 0;
        }*/
        return new self(
            name: $request->input('name', ''),
            state: $request->input('state'),


        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'state' => $this->state,
        ];
    }
}
