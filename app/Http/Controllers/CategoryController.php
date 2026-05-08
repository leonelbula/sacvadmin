<?php

namespace App\Http\Controllers;

use App\DTOs\CategoryDTO;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {

        $categories = $this->categoryService->getAllCategories();
        $title = 'Categorias';
        return view(
            'category.index',
            compact(
                'categories',
                'title'
            )
        );
    }
    public function create()
    {
        $title = 'Nueva Categoria';
        return view('category.create', compact('title'));
    }
    public function store(CategoryStoreRequest $request)
    {

        $categoryDTO = CategoryDTO::fromRequest($request);
        $this->categoryService->createCategory($categoryDTO);

        toastr()->success('Registro guardado');
        return back();
        // return redirect()->route('categoria.index');
    }

    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.edit', compact('category'));
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $title = 'Editar Categorias';
        return view('category.edit', compact('category', 'title'));
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
