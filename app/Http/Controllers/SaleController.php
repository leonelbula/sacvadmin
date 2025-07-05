<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Term;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Lista de ventas";
        $sales = Sale::orderBy('id', 'DESC')->get();
        return view('sale.index', compact('title', 'sales'));
    }
    public function create()
    {
        $title = 'Nueva venta';
        $customers = Customer::all();
        $products = Product::all();
        $terms = Term::all();
        return view('sale.create', compact('title', 'terms', 'customers','products'));
    }

    public function store(Request $request)
    {
        $listProduct = json_decode($request->listaProductos, true);

        $product = new Product();
        $cost = 0;
        foreach ($listProduct as $product) {

            $productDetalle = Product::where('id', $product['id'])->first();
            $amount = $productDetalle['amount'];
            $newAmount = $amount - $product['cantidad'];

            $productDetalle['amount'] = $newAmount;
            $productDetalle->save();
            $cost += $product['costo'];
        }
        $utility = $request->totalVenta - $cost;

        $sale = new Sale();
        $lastSave = $sale::all()->last();


        if (isset($lastSave)) {
            $code_save = $lastSave->sale_number;
            $code_save++;
        } else {
            $parameter = Parameter::find(1);
            $code_save =  $parameter->sale_code;
            $code_save++;
        }
        if ($request->tipoventa == 1) {

            $dias = $request->plazos;
            $fecha = $request->fecha;
            $fechaActual = strtotime('+' . $dias . ' day', strtotime($fecha));
            $expiration_date = date('Y-m-d', $fechaActual);
            $balance = $request->totalVenta;
        } else {
            $balance = 0;
            $expiration_date = $request->fecha;
        }

        $sale->sale_number = $code_save;
        $sale->content = $request->listaProductos;
        $sale->cost = $cost;
        $sale->utility = $utility;
        $sale->total = $request->totalVenta;
        $sale->balance = $balance;
        $sale->hour = date('h:i:s');
        $sale->date_sale = $request->fecha;
        $sale->expiration_date = $expiration_date;
        $sale->customer_id = $request->idcliente;
        $sale->user_id = auth()->user()->id;
        $sale->type_sale = $request->tipoventa;

        $sale->save();
        $sale_id = $sale->id;

        $saleProducto = new SaleProduct();

        foreach ($listProduct as $product) {

            $saleProducto->amount = $product['cantidad'];
            $saleProducto->fecha = $request->fecha;
            $saleProducto->product_id = $product['id'];
            $saleProducto->sale_id = $sale_id;
            $saleProducto->save();
        }
        return redirect()->route('venta.index');
    }
    public function edit(Sale $sale)
    {
        $title = "Editar Venta";
        $customer = Customer::find($sale->customer_id);
        $terms = Term::all();
        return view('sale.edit', compact('customer', 'sale', 'terms', 'title'));
    }
}
