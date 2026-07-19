<?php
namespace App\Interfaces;

interface SaleRepositoryInterface
{
    public function All();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

}