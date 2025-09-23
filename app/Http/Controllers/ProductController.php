<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Company;
use App\Models\ProductType;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $products = Product::where('company_id', Auth::user()->company_id)
                ->where(function ($queryBuilder) use ($search) {
                    $queryBuilder->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('code', 'LIKE', "%{$search}%");
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $compania = Company::findOrFail(Auth::user()->company_id);
            $products = $compania->products()
                ->orderBy('name', 'asc')
                ->paginate(10);
        }

        $title = 'Lista de Productos';
        return view('product.index', compact('products', 'title', 'search'));
    }
    public function search(Request $request)
    {
        $query = $request->get('q');

        $productos = Product::where('company_id', Auth::user()->company_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('code', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'code', 'price', 'amount', 'cost', 'tax']);


        return response()->json($productos);
    }
    public function create()
    {
        $title = 'Nuevo Producto';
        $taxes = Tax::all();
        $productTypes = ProductType::all();
        $compania = Company::findOrFail(Auth::user()->company_id);
        $categories = $compania->categories()
            ->orderBy('name', 'asc')->get();
        $parameter = $compania->parameters()->first();
        if ($parameter) {
            $automatic_product = $parameter->automatic_product;
        } else {
            $automatic_product = 0;
        }


        return view('product.create', compact(
            'title',
            'categories',
            'automatic_product',
            'taxes',
            'productTypes',
        ));
    }
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $compania = Company::findOrFail(Auth::user()->company_id);
        $parameter = $compania->parameters()->first();


        DB::beginTransaction();
        try {

            if (!$request->code) {
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
            } else {
                $data['code'] = $request->code;
            }

            if ($request->state == '1') {
                $data['state'] = true;
            } else {
                $data['state'] = false;
            }

            if (intval($request->tax_value) != 0) {
                $data['tax'] = true;
            } else {
                $data['tax'] = false;
            }
            $data['company_id'] = Auth::user()->company_id;

            Product::create($data);
            DB::commit();
            toastr()->success('Nuevo producto Registro');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
    public function show(Product $product)
    {
        $title = 'Producto detalles';
        return view('product.show', compact('product', 'title'));
    }
    public function edit(Product $product)
    {

        $title = 'Editar Producto';
        $taxes = Tax::all();
        $productTypes = ProductType::all();
        $compania = Company::findOrFail(Auth::user()->company_id);
        $categories = $compania->categories()
            ->orderBy('name', 'asc')->get();
        $parameter = $compania->parameters()->first();
        if ($parameter) {
            $automatic_product = $parameter->automatic_product;
        } else {
            $automatic_product = 0;
        }
        return view('product.edit', compact(
            'product',
            'title',
            'categories',
            'automatic_product',
            'taxes',
            'productTypes'
        ));
    }
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $compania = Company::findOrFail(Auth::user()->company_id);
        $parameter = $compania->parameters()->first();

        DB::beginTransaction();
        try {

            if (!$request->code) {
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
            } else {
                $data['code'] = $request->code;
            }

            if ($request->state == '1') {
                $data['state'] = true;
            } else {
                $data['state'] = false;
            }

            if (intval($request->tax_value) != 0) {
                $data['tax'] = true;
            } else {
                $data['tax'] = false;
            }

            $product->update($data);

            DB::commit();
            toastr()->success('Producto Actulizado');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
    public function destroy(Product $product)
    {
        $product->delete();
        toastr()->success('Registro Eliminado');
        return redirect(route('product.index'));
    }
}
