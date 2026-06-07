<?php
namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    public function find(int $id);
    public function all();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function search(string $query);
}