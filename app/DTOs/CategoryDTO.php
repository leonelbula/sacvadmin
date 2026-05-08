<?php
namespace app\DTOs;

class CategoryDTO
{
    public int $id;
    public string $name;
    public int $state;
    public int $company_id;
    public string $created_at;
    public string $updated_at;

    public function __construct(int $id, string $name, int $state, int $company_id,  string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->state = $state;
        $this->company_id = $company_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public static function fromRequest($request): self
    {
        return new self(
            id: $request->input('id', 0),
            name: $request->input('name', ''),          
            state: $request->input('state', 1),
            company_id: $request->input('company_id', 0),
            created_at: $request->input('created_at', date('Y-m-d H:i:s')),
            updated_at: $request->input('updated_at', date('Y-m-d H:i:s'))
        );
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,          
            'state' => $this->state,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}