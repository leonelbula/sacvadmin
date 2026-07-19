<?php
namespace App\Repositories;
use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use App\DTOs\SaleDTO;

class SaleRepository implements SaleRepositoryInterface
{
    public function All(){
        return Sale::orderBy('id', 'desc')->paginate(10);
    }
    public function findById($id){
        return Sale::findOrFail($id);
    }
    public function create(array $data){
        return Sale::create($data);
    }
    public function update($id, array $data){
        $sale = Sale::findOrFail($id);
        $sale->update($data);
        return $sale;
    }
    public function delete($id){
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return $sale;
    }
}