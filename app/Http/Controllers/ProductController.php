<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Company;
use App\Models\Kardex;
use App\Models\ProductType;
use App\Models\Tax;
use App\Services\CategoryService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\DTOs\ProductDTO;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $products = $this->productService->searchProducts($search);
        } else {
            $products = $this->productService->getAllProducts();
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
        $categories = $this->categoryService->getAllCategories();

        $taxes = Tax::all();
        $productTypes = ProductType::all();

        $compania = Company::findOrFail(Auth::user()->company_id);
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

        $dto = ProductDTO::fromRequest($request);

        $product = $this->productService->create($dto);

        if ($product) {
            toastr()->success('Nuevo producto Registro');
        } else {
            toastr()->error('Error al guardar la informacion');
        }

        return back();
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
        $dto = ProductDTO::fromRequest($request);
        $updatedProduct = $this->productService->update($product->id, $dto);

        toastr()->success('Registro Actualizado');
        return redirect(route('product.index'));
    }
    public function destroy(int $id)
    {
        $result = $this->productService->delete($id);
        if ($result) {
            toastr()->success('Registro Eliminado');
        } else {
            toastr()->error('Error al eliminar el registro');
        }
        return redirect(route('product.index'));
    }
    //corregir filtrar cor compañia
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
    public function settings()
    {
        $title = 'Ajustes Inventario';
        return view('product.ajustes', compact('title'));
    }
    public function saveSettings(Request $request)
    {

        DB::beginTransaction();
        try {
            $product = Product::find($request->product_id);

            $amountAct = $product->amount;
            $newProduc = $request->newAmount + $amountAct;
            $product->amount = $newProduc;

            $product->update();

            DB::commit();
            toastr()->success('Cantidad de producto Actualizada');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
}
