<?php

namespace App\Services; // Asegúrate de agregar el namespace correcto

use App\Actions\Pos\PosCreateAction;
use App\Actions\Pos\PosUpdateAction;
use App\DTOs\PosDTO;
use App\Interfaces\PosRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Pos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PosService
{
    public function __construct(
        protected PosRepositoryInterface $pos_repository,
        protected PosCreateAction $pos_create_action,
        protected PosUpdateAction $pos_update_action,
        protected SaleRepositoryInterface $sale_repository
    ) {}

    public function All(): LengthAwarePaginator
    {
        return $this->pos_repository->All();
    }

    public function findById(int $id): Pos
    {
        return $this->pos_repository->findById($id);
    }

    public function create(PosDTO $data): Pos
    {
        return $this->pos_create_action->execute($data);
    }

    public function update(int $id, PosDTO $data): Pos
    {
        return $this->pos_update_action->execute($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->pos_repository->delete($id);
    }

    public function lastPos(): ?Pos
    {
        return $this->pos_repository->lastPos();
    }

    public function posActive(int $idUser): ?Pos
    {
        return $this->pos_repository->posActive($idUser);
    }

   
}
