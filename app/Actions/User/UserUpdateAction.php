<?php

namespace App\Actions\User;

use App\DTOs\UserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserUpdateAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user, UserDTO $dto): User
    {
        return DB::transaction(function () use ($user, $dto) {

            $user = $this->userRepository->update(
                $user,
                $dto
            );

            if ($dto->role !== null) {
                $user->syncRoles([$dto->role]);
            }

            return $user->fresh()->load('roles');
        });
    }
}
