<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleProduct;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SaleController extends Controller
{

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
        /*$listProduct = json_decode($request->listaProductos, true);

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
        return redirect()->route('venta.index');*/
        $request->validate([
        'client_id' => 'required|exists:clients,id',
        'sale_type' => 'required|in:contado,credito',
        'due_date' => 'nullable|date',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.price' => 'required|numeric|min:0',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.discount' => 'nullable|numeric|min:0',
        'products.*.iva' => 'nullable|in:on',
    ]);

    try {
        DB::beginTransaction();

        $subtotal = 0;
        $totalIVA = 0;
        $total = 0;

        // Crear la venta principal
        $sale = Sale::create([
            'client_id'   => $request->client_id,
            'sale_type'   => $request->sale_type,
            'due_date'    => $request->sale_type === 'credito' ? $request->due_date : null,
            'subtotal'    => 0, // temporal
            'total_iva'   => 0, // temporal
            'total'       => 0, // temporal
            'sale_date'   => now(),
        ]);

        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price = $item['price'];
            $quantity = $item['quantity'];
            $discount = $item['discount'] ?? 0;
            $hasIVA = isset($item['iva']) && $item['iva'] === 'on';

            $lineTotal = ($price * $quantity) - $discount;
            $iva = $hasIVA ? $lineTotal * 0.19 : 0;
            $lineTotalWithIVA = $lineTotal + $iva;

            // Crear detalle
            SaleDetail::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id,
                'price'      => $price,
                'quantity'   => $quantity,
                'discount'   => $discount,
                'iva'        => $iva,
                'subtotal'   => $lineTotalWithIVA,
            ]);

            // Actualizar stock del producto
            $product->stock -= $quantity;
            $product->save();

            $subtotal += $lineTotal;
            $totalIVA += $iva;
        }

        $total = $subtotal + $totalIVA;

        // Actualizar totales en la venta
        $sale->update([
            'subtotal' => $subtotal,
            'total_iva' => $totalIVA,
            'total' => $total,
        ]);

        DB::commit();

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
    }
    }
    public function edit(Sale $sale)
    {
        $title = "Editar Venta";
        $customer = Customer::find($sale->customer_id);
        $terms = Term::all();
        return view('sale.edit', compact('customer', 'sale', 'terms', 'title'));
    }
}
