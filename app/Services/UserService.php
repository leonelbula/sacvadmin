<?php

namespace App\Services;

use App\Action\User\UserCreateAction;
use App\Action\User\UserDeleteAction;
use App\Action\User\UserUpdateAction;
use App\DTOs\UserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserCreateAction $createAction,
        protected UserUpdateAction $updateAction,
        protected UserDeleteAction $deleteAction,
    ) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getAll($perPage);
    }

    public function findById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function create(UserDTO $dto): User
    {
        return $this->createAction->execute($dto);
    }

    public function update(User $user, UserDTO $dto): User
    {
        return $this->updateAction->execute($user, $dto);
    }

    public function delete(User $user): bool
    {
        return $this->deleteAction->execute($user);
    }
}
