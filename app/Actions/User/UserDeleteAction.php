<?php

namespace App\Action\User;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDeleteAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(User $user): bool
    {
        return DB::transaction(function () use ($user) {

            return $this->userRepository->delete($user);
        });
    }
}
