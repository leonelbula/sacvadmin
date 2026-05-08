<?php
namespace App\Actions\Category;

use App\Models\Category;
use App\DTOs\CategoryDTO;

class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        $category->delete();
    }
}
    