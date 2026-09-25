<?php

namespace App\Interfaces;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;

    public function findById(int $id): User;

    public function create(UserDTO $dto): User;

    public function update(User $user, UserDTO $dto): User;

    public function delete(User $user): bool;
}
