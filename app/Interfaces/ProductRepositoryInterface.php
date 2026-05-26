<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function searchProducts(
        ?string $search = null,
        int $perPage = 10
    );

    public function getAllProducts();

    public function findOrFail(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getNextCode();
}
