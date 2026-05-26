<?php
namespace App\Repositories;

use App\Interfaces\KardexRepositoryInterface;
use App\Models\Kardex;

class KardexRepository implements KardexRepositoryInterface
{
    public function create(array $data)
    {
        return Kardex::create($data);
    }
    public function all()
    {
        return Kardex::with('product')->orderBy('date', 'desc')->paginate(10);
    }
    public function find($id)
    {
        return Kardex::find($id);
    }
}