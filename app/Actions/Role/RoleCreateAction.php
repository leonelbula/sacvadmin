<?php

namespace App\Actions\Role;

use App\DTOs\RoleDTO;
use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleCreateAction
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(RoleDTO $dto): Role
    {
        return DB::transaction(function () use ($dto) {
            return $this->roleRepository->create($dto);
        });
    }
}
