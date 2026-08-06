<?php

namespace App\Interfaces;


interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function searchCategories(?string $search = null, int $perPage = 10);
    public function getCategoryById(int $id);
    public function createCategory(array $data);
    public function updateCategory(int $id, array $data);
    public function deleteCategory(int $id);
}
