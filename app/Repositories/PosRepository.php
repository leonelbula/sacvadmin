<?php

namespace App\Repositories;

use App\Interfaces\PosRepositoryInterface;
use App\Models\Pos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PosRepository implements PosRepositoryInterface
{
    public function All(): LengthAwarePaginator
    {
        return Pos::orderBy('id', 'desc')->paginate(10);
    }

    public function findById(int $id): Pos
    {
        // Lanza ModelNotFoundException (404) si no existe
        return Pos::findOrFail($id);
    }

    public function create(array $data): Pos
    {
        return Pos::create($data);
    }

    public function update(int $id, array $data): Pos
    {
        $pos = $this->findById($id);
        $pos->update($data);
        return $pos;
    }

    public function delete(int $id): bool
    {
        // Al usar findById, si no existe ya lanza la excepción automáticamente
        $pos = $this->findById($id);

        return (bool) $pos->delete();
    }

    public function lastPos(): ?Pos
    {
        return Pos::latest('id')->first();
    }

    // Corregido: Se agrega el "?" porque si el usuario no tiene cajas, devolverá null
    public function posActive(int $idUser): ?Pos
    {
        return Pos::where('user_id', $idUser)->latest()->first();
    }
}
