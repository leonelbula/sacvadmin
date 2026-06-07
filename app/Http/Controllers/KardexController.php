<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;

class KardexController extends Controller
{
    public function __construct(protected KardexService $kardexService) {}
    public function index(Request $request)
    {
         $title = "Productos Inventario Kardex";
        $search = $request->input('search');
        if ($search != '') {
            $all = $this->kardexService->search($search);
            return view('kardex.index', compact('title', 'all', 'search'));
        }else {           
            $all = $this->kardexService->all();
            return view('kardex.index', compact('title', 'all', 'search'));
        }
       
    }
    public function show($id)
    {
        $title = "Detalle del Movimiento de Inventario";
        $detail = $this->kardexService->allId($id);
        return view('kardex.show', compact('title', 'detail'));
    }   
}
