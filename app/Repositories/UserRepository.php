<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): User
    {
        return User::query()
            ->with('roles')
            ->findOrFail($id);
    }

    public function create(UserDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'type' => $dto->type,
            'state' => $dto->state,
            'password' => $dto->password,
        ]);
    }

    public function update(User $user, UserDTO $dto): User
    {
        $data = [
            'name' => $dto->name,
            'email' => $dto->email,
            'type' => $dto->type,
            'state' => $dto->state,
        ];

        if ($dto->password !== null) {
            $data['password'] = $dto->password;
        }

        $user->update($data);

        return $user->fresh()->load('roles');
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
