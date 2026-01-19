<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Company;
use App\Models\Kardex;
use App\Models\ProductType;
use App\Models\Tax;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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
    public function search($query)
    {
        $productos = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('code', $query)
            ->orderBy('name', 'asc')
            ->limit(10)
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

            $productNew = Product::create($data);
            ///kardex
            $dataKardex = [
                'product_id' => $productNew->id,
                'date' => now(),
                'movement_type' => 'INGRESO',
                'origin' => 'INVENTARIO',
                'reference_id' => 0,
                'quantity' => $data['amount'],
                'stock_before' => 0,
                'stock_after' => $data['amount'],
                'unit_cost' => $data['price'],
                'company_id' => Auth::user()->company_id
            ];
            Kardex::create($dataKardex);
            DB::commit();
            toastr()->success('Nuevo producto Registro');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            //dd($e->getMessage());
            //die();
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

            ///kardex
            if ($product->amount != $data['amount']) {
                if ($product->amount < $data['amount']) {
                    $quantity =  $data['amount'] - $product->amount;
                } else {
                    $quantity =  $data['amount'] - $product->amount;
                }
                $stockBefore = $product->amount;
                $stockAfter = $data['amount'];

                $dataKardex = [
                    'product_id' => $product->id,
                    'date' => now(),
                    'movement_type' => 'INGRESO',
                    'origin' => 'INVENTARIO -  AJUSTE',
                    'reference_id' => 0,
                    'quantity' => $quantity,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'unit_cost' => $data['price'],
                    'company_id' => Auth::user()->company_id
                ];
                Kardex::create($dataKardex);
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

    public function reporteValorInventario()
    {
        // Traer productos con stock > 0
        $productos = Product::select('id', 'code', 'name', 'amount', 'cost', 'price')
            ->where('amount', '>', 0)
            ->get();

        // Calcular totales
        $totalCosto = $productos->sum(fn($p) => $p->amount * $p->cost);
        $totalVenta = $productos->sum(fn($p) => $p->amount * $p->price);

        $pdf = Pdf::loadView('reports.inventario_valor', [
            'productos' => $productos,
            'totalCosto' => $totalCosto,
            'totalVenta' => $totalVenta,
        ]);

        return $pdf->setPaper('letter')->stream('reporte_inventario.pdf');
    }
}
