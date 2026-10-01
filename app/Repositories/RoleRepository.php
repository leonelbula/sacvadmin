<?php

namespace App\Repositories;

use App\DTOs\RoleDTO;
use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Role::query()
            ->withCount('permissions')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function findById(int $id): Role
    {
        return Role::query()
            ->with([
                'permissions',
            ])
            ->findOrFail($id);
    }

    public function getPermissions()
    {
        return Permission::query()
            ->orderBy('name')
            ->get();
    }

    public function create(RoleDTO $dto): Role
    {
        $role = Role::create([
            'name' => $dto->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($dto->permissions);

        return $role->load('permissions');
    }

    public function update(Role $role, RoleDTO $dto): Role
    {
        $role->update([
            'name' => $dto->name,
        ]);

        $role->syncPermissions($dto->permissions);

        return $role->fresh()->load('permissions');
    }

    public function delete(Role $role): bool
    {
        return (bool) $role->delete();
    }
}
