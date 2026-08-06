<?php
namespace App\Repositories;

use App\Interfaces\TaxRepositoryInterface;
use App\Models\Tax;

class TaxRepository implements TaxRepositoryInterface
{
    public function all()
    {
        return Tax::all();
    }

    public function find(int $id)
    {
        return Tax::find($id);
    }

    public function create(array $data)
    {
        return Tax::create($data);
    }

    public function update(int $id, array $data)
    {
        $tax = Tax::find($id);
        if ($tax) {
            $tax->update($data);
            return $tax;
        }
        return null;
    }

    public function delete(int $id)
    {
        $tax = Tax::find($id);
        if ($tax) {
            $tax->delete();
            return true;
        }
        return false;
    }
}