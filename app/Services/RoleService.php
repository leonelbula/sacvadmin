<?php

namespace App\Services;

use App\Actions\Role\RoleCreateAction;
use App\Actions\Role\RoleDeleteAction;
use App\Actions\Role\RoleUpdateAction;
use App\DTOs\RoleDTO;
use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository,
        protected RoleCreateAction $createAction,
        protected RoleUpdateAction $updateAction,
        protected RoleDeleteAction $deleteAction,
    ) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->roleRepository->getAll($perPage);
    }

    public function findById(int $id): Role
    {
        return $this->roleRepository->findById($id);
    }

    public function getPermissions()
    {
        return $this->roleRepository->getPermissions();
    }

    public function create(RoleDTO $dto): Role
    {
        return $this->createAction->execute($dto);
    }

    public function update(Role $role, RoleDTO $dto): Role
    {
        return $this->updateAction->execute($role, $dto);
    }

    public function delete(Role $role): bool
    {
        return $this->deleteAction->execute($role);
    }
}
