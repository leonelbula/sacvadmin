<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AjaxProduct extends Controller
{
    public function productAll()
    {
        $products = Product::select('id','code', 'name', 'amount', 'price')->where('state', 1)->get();
        $i = 1;

        foreach ($products as $product) {
            $listProduct[] = array($i++,
                             $product->code,
                             $product->name,
                             $product->price,
                             $product->amount,
                             "<button type='button'
                             class='btn btn-primary agregarProducto recuperarBoton'
                             idProducto='".$product->id."'>Agregar
                             </button>");
        }
        return response()->json(['data' =>$listProduct], 200);
    }
    public function productGet(Request $request)
    {
        $products = Product::select('id','code', 'name', 'amount', 'cost', 'price')->where('id', $request->id)->get();

        return response()->json($products);
    }
}
