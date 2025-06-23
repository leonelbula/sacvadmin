<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        try {

            Category::create($request->validated());

            toastr()->success('Registro Guardado');

            return back();
        } catch (Exception $e) {
            toastr()->error('Registro no Guardado');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
            toastr()->success('Registro Guardado');
            return back();
        } catch (Exception $e) {
            toastr()->error('Registro no Guardado');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            toastr()->success('Registro Eliminado');
            return redirect()->route('category.index');
        } catch (Exception $e) {
            toastr()->error('Registro no Guardado');
            return redirect()->route('category.index');
        }
    }
}
