<?php

namespace App\Actions\Role;

use App\DTOs\RoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleUpdateAction
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(Role $role, RoleDTO $dto): Role
    {
        return DB::transaction(function () use ($role, $dto) {
            return $this->roleRepository->update($role, $dto);
        });
    }
}
