<?php

namespace App\Actions\Role;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleDeleteAction
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository
    ) {}

    public function execute(Role $role): bool
    {
        return $this->roleRepository->delete($role);
    }
}
