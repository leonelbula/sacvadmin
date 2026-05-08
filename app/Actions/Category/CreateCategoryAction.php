<?php
namespace App\Actions\Category;

use App\Models\Category;
use App\DTOs\CategoryDTO;

class CreateCategoryAction
{
    public function execute(CategoryDTO $categoryDTO): Category
    {
        $data = $categoryDTO->toArray();
        return Category::create($data);
    }
}
