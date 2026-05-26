<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KardexService;

class KardexController extends Controller
{
    public function __construct(protected KardexService $kardexService) {}
    public function index()
    {

        $title = "Productos Inventario Kardex";
        $all = $this->kardexService->all();
        return view('kardex.index', compact('title', 'all'));
    }
}
