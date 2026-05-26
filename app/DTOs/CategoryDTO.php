<?php
namespace App\DTOs;

class CategoryDTO
{
   

    public function __construct(
       public readonly int $id, 
       public readonly string $name, 
       public readonly int $state, 
       public readonly int $company_id
    )
    {

    }
    public static function fromRequest($request): self
    {
        return new self(
            id: $request->input('id', 0),
            name: $request->input('name', ''),          
            state: $request->input('state', 1),
            company_id: $request->input('company_id', 0)
           
        );
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,          
            'state' => $this->state,
            'company_id' => $this->company_id
            
        ];
    }
}