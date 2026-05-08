<?php
namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Repositories\CategoryRepository;
use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\UpdateCategoryAction;
use App\Actions\Category\DeleteCategoryAction;




class CategoryService
{
  

    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected CreateCategoryAction $createCategoryAction,
        protected UpdateCategoryAction $updateCategoryAction,
        protected DeleteCategoryAction $deleteCategoryAction
        )
    {}

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }

    public function createCategory(CategoryDTO $categoryDTO)
    {
      
        return $this->createCategoryAction->execute($categoryDTO);
    }

    public function updateCategory($id, CategoryDTO $categoryDTO)
    {
        $category = $this->categoryRepository->getCategoryById($id);
        return $this->updateCategoryAction->execute($category, $categoryDTO);
    }

    public function deleteCategory(int $id)
    {
         $category = $this->categoryRepository->getCategoryById($id);
        return $this->deleteCategoryAction->execute($category);
    }
}