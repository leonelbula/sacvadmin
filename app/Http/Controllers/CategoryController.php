<?php

namespace App\Http\Controllers;

use App\DTOs\CategoryDTO;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Category $category = null,Request $request)
    {
        $search = $request->input('search');
    
        if ($search) {
            $categories = $this->categoryService->searchCategory($request->input('search'));
        } else {
           $categories = $this->categoryService->getAllCategories(10);
        }

        
        $title = 'Categorias';
        return view(
            'category.index',
            compact(
                'categories',
                'title',
                'category'
            )
        );
    }
   
    public function store(CategoryStoreRequest $request)
    {
       
        $categoryDTO = CategoryDTO::fromRequest($request);
        $this->categoryService->createCategory($categoryDTO);

        toastr()->success('Registro guardado');
        return back();
        // return redirect()->route('categoria.index');
    } 
   

    public function update(CategoryStoreRequest $request, int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $categoryDTO = CategoryDTO::fromRequest($request);
        $this->categoryService->updateCategory($id, $categoryDTO);
        toastr()->success('Registro guardado');

        return back();
    }

    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);
        toastr()->success('Registro Eliminado');
        return redirect()->route('category.index');
    }
}
