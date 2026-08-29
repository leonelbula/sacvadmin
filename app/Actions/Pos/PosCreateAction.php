<?php

namespace App\Actions\Pos;

use App\DTOs\PosDTO;
use App\Models\Pos;
use App\Repositories\PosRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class PosCreateAction
{
    public function __construct(
        protected PosRepository $pos_repository,
    ) {}

    public function execute(PosDTO $dto): Pos
    {
        // 1. Validar que el DTO tenga los datos mínimos (o confiar en la validación previa del Request)
        if (empty($dto)) {
            throw new Exception("Datos insuficientes o saldo inicial inválido para iniciar la caja.");
        }


        return DB::transaction(function () use ($dto) {

            // Convertimos el DTO en array para que el repositorio cree el registro
            return $this->pos_repository->create($dto->toArray());
        });
    }
}
