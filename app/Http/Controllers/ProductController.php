<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $compania = Company::findOrFail(Auth::user()->company_id);
        $products = $compania->products()
            ->orderBy('name', 'asc')
            ->paginate(10);
        $title = 'Lista de Productos';
        return view('product.index', compact('products', 'title'));
    }
    public function create()
    {
        $title = 'Nuevo Producto';

        $compania = Company::findOrFail(Auth::user()->company_id);
        $categories = $compania->categories()
            ->orderBy('name', 'asc')
            ->paginate(10);
        $parameter = $compania->parameters()->first();
        $automatic_product = $parameter->automatic_product;

        return view('product.create', compact('title', 'categories', 'automatic_product'));
    }
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $compania = Company::findOrFail(Auth::user()->company_id);
        $parameter = $compania->parameters()->first();

        if ($parameter->automatic_product) {
            $product = $compania->products()
                ->orderBy('created_at', 'desc')
                ->first();
            if ($product) {
                $code = (int)$product->code + 1;
            } else {
                $code = $parameter->product_code;
            }

            $data['code'] = $code;
        }

        $data['company_id'] = Auth::user()->company_id;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public/products');
        } else {
            $data['image'] = '';
        }

        if ($request->state == 'on') {
            $data['state'] = 1;
        } else {
            $data['state'] = 0;
        }

        Product::create($data);

        toastr()->success('Nuevo producto Registro');
        return back();
    }
    public function show(Product $product)
    {
        $title = 'Producto detalles';
        return view('product.show', compact('product', 'title'));
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        $title = 'Editar Producto';
        return view('product.edit', compact('product', 'categories', 'title'));
    }
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public/products');
        } else {
            $data['image'] = '';
        }

        if ($request->state == 'on') {
            $data['state'] = 1;
        } else {
            $data['state'] = 0;
        }

        $product->update($data);

        toastr()->success('Registro guardado');
        return back();
    }
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        toastr()->success('Registro Eliminado');
        return redirect(route('product.index'));
    }
}
