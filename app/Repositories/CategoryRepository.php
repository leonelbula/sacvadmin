<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories($paginate = null)
    {
        if($paginate){
            return Category::orderBy('name', 'asc')->paginate($paginate);
        }else{
            return Category::all();
        }

    }

    public function searchCategories(?string $search = null, int $perPage = 10)
    {
        return Category::where('name', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%")

            ->orderBy('name')

            ->paginate($perPage)

            ->withQueryString();
    }

    public function getCategoryById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        $category = Category::findOrFail($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function deleteCategory(int $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}
