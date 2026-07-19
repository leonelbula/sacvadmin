<?php
namespace App\Interfaces;

interface SaleDetailRepositoryInterface
{
    public function create(array $data);
    public function Update($sale_id, array $data);
    public function delete($sale_id);
    public function findBySaleId($sale_id);
}