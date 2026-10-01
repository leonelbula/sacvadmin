<?php

namespace App\Interfaces;

use App\DTOs\RoleDTO;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): Role;

    public function getPermissions();

    public function create(RoleDTO $dto): Role;

    public function update(Role $role, RoleDTO $dto): Role;

    public function delete(Role $role): bool;
}
