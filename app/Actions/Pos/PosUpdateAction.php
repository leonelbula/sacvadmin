<?php

namespace App\Actions\Pos;

use App\DTOs\PosDTO;
use App\Models\Pos;
use App\Repositories\PosRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class PosUpdateAction
{
    public function __construct(
        protected PosRepository $pos_repository,
    ) {}

    public function execute(int $id, PosDTO $dto): Pos
    {

        if ($id <= 0 || $dto->box_base < 0) {
            throw new Exception("ID de caja inválido o base de caja incorrecta para Cerrar.");
        }


        return DB::transaction(function () use ($id, $dto) {


            return $this->pos_repository->update($id, $dto->toArray());
        });
    }
}
