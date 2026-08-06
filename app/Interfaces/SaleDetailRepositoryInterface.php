<?php
namespace App\Interfaces;

interface SaleDetailRepositoryInterface
{
    public function create(array $data);
    public function Update(int $sale_id, array $data);
    public function delete(int $sale_id);
    public function findBySaleId(int $sale_id);
}