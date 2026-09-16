<?php

namespace App\Actions\Pos;

use App\DTOs\PosDTO;
use App\Interfaces\PosRepositoryInterface;
use App\Models\Pos;
use Illuminate\Support\Facades\DB;
use Exception;

class PosUpdateAction
{
    public function __construct(
        protected PosRepositoryInterface $pos_repository,
    ) {}

    public function execute(int $id, array $data): Pos
    {

        if ($id <= 0) {
            throw new Exception("ID de caja inválido o base de caja incorrecta para Cerrar.");
        }

        return DB::transaction(function () use ($id, $data) {
            $consignment = (int)$data['total_sale'] - (int) $data['cash'];
            $data['consignment'] = $consignment;
            $data['closing_date'] = now()->format('Y-m-d');
            $data['state'] = 1;
            return $this->pos_repository->update($id, $data);
        });
    }
}
