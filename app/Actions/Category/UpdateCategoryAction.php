<?php
namespace App\Actions\Category;

use App\Models\Category;
use App\DTOs\CategoryDTO;

class UpdateCategoryAction
{
    public function execute(Category $category, CategoryDTO $categoryDTO): Category
    {
        $data = $categoryDTO->toArray();
        $category->update($data);
        return $category;
    }
}