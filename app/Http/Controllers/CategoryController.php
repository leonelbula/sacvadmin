<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{


    public function index()
    {
        $compania = Company::findOrFail(Auth::user()->company_id);
        $categories = $compania->categories()
            ->orderBy('name', 'asc')
            ->paginate(10);
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
    public function store(Request $request)
    {

        if (!Auth::user()->company_id) {
            toastr()->error('Registro no guardado');
            toastr()->warning('Debe registrar una empresa');
            return back();
        }

        $request->validate([
            'name' => 'required'
        ]);

        $name = $request->input('name');
        $state = $request->input('state');

        if ($state == 'on') {
            $state = true;
        } else {
            $state = false;
        }
        //asignacion masiva Category::create($request->all());
        $category = new Category();
        $category->name = $name;
        $category->state = $state;
        $category->company_id = Auth::user()->company_id;
        $category->save();
        toastr()->success('Registro guardado');
        return back();
        // return redirect()->route('categoria.index');
    }

    public function show(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function edit(Category $category)
    {
        $title = 'Editar Categorias';
        return view('category.edit', compact('category', 'title'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->name = $request->name;

        $state = $request->input('state');

        if ($state == 'on') {
            $state = true;
        } else {
            $state = false;
        }

        $category->state = $state;
        //$categoru->update($request->all())
        $category->save();

        toastr()->success('Registro guardado');

        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        toastr()->success('Registro Eliminado');
        return redirect()->route('category.index');
    }
}
