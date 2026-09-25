<?php

namespace App\Action\User;

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

            return $this->userRepository->create($dto);
        });
    }
}
