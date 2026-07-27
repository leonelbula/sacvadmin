<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;
use App\Services\ProductService;

class KardexController extends Controller
{
    public function __construct(protected KardexService $kardexService, protected ProductService $productService) {}
    public function index(Request $request)
    {
        $title = "Productos Inventario Kardex";
        $search = $request->input('search');
        $movimentos = $this->kardexService->countRegistro();
        $totalProduct = $this->productService->countProduct();


        if ($search != '') {
            $all = $this->kardexService->search($search);

            return view('kardex.index', compact(
                'title',
                'all',
                'search',
                'movimentos',
                'totalProduct'
            ));
        } else {
            $all = $this->kardexService->all();
            return view('kardex.index', compact(
                'title',
                'all',
                'search',
                'movimentos',
                'totalProduct'
            ));
        }
    }
    public function show($id)
    {
        $title = "Detalle del Movimiento de Inventario";
        $produc = $this->kardexService->getId($id);
        $detail = $this->kardexService->allId($id);
        return view('kardex.show', compact('title', 'detail' ,'produc'));
    }
     public function showDetail($id)
    {
        $title = "Detalle del Movimiento de Inventario";
        $detail = $this->kardexService->getId($id);
       return view('kardex.showdetaIl', compact('title','detail'));
    }
}
