<?php

namespace App\Repositories;

use App\Interfaces\KardexRepositoryInterface;
use App\Models\Kardex;
use Override;

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
        return Kardex::where('product_id', $id)->get();
    }

    public function countRegister()
    {

        return $totales = Kardex::selectRaw("
                            COUNT(*) as total,
                            SUM(CASE WHEN income > 0 THEN 1 ELSE 0 END) as total_income,
                            SUM(CASE WHEN output < 0 THEN 1 ELSE 0 END) as total_output
                        ")->first();
    }
     public function getId($id)
    {
        return Kardex::find($id);
    }

}
