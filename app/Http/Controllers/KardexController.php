<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function index()
    {
        $title = "Productos Inventario";
        return view('product.kardex', compact('title'));
    }
}
