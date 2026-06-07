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
    public function search($query)
    {
        return Kardex::with('product')
            ->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('code', 'like', "%$query%");
            })            
            ->orderBy('date', 'desc')
            ->paginate(10);
    }
    public function allId($id)
    {
        return Kardex::where('id', $id)->get();
    }
}