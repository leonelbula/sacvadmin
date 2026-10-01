<?php

namespace App\Actions\User;

use App\DTOs\UserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserCreateAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(UserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {

            $user = $this->userRepository->create($dto);

            if ($dto->role !== null) {
                $user->assignRole($dto->role);
            }

            return $user->load('roles');
        });
    }
}
