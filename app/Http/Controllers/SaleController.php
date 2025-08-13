<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Parameter;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleProduct;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $payments = PaymentMethod::all();
        $products = Product::all();
        $terms = Term::all();
        return view('sale.create', compact('title', 'terms', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date_sale'   => 'required|date',
            'payment_form' => 'required|in:counted,credit',
            'subtotal'    => 'required|numeric|min:0',
            'iva'         => 'nullable|numeric|min:0',
            'total'       => 'required|numeric|min:0',
            'products'    => 'required|array|min:1',
            'products.*'  => 'exists:products,id',
            'quantities'  => 'required|array|min:1',
            'quantities.*' => 'numeric|min:1',
            'prices'      => 'required|array|min:1',
            'prices.*'    => 'numeric|min:0',
            'tax'         => 'required|array|min:1',
            'tax.*'       => 'numeric|min:0',
            'cost_product' => 'required|array|min:1',
            'cost_product.*' => 'numeric|min:0',
        ]);



        try {
            DB::beginTransaction();
            //var_dump($request->all());
            $company_id = Auth::user()->company_id;
            $compania = Company::findOrFail($company_id);
            $last_sale = Sale::where('company_id', $company_id)
                ->orderBy('id', 'desc')
                ->first();
            $parameter = $compania->parameters()->first();

            if ($last_sale) {
                $saleNumber = $last_sale->sale_number + 1;
            } else {
                $saleNumber = $parameter->sale_code + 1;
            }

            $cost = $request->costs;
            $utility = $request->total - $request->costs;
            if ($request->payment_form == 'counted') {
                $balance = 0;
            } else {
                $balance = $request->total;
            }

            if ($request->payment_form == 'counted') {
                $expiration_date = $request->date_sale;
                $type_sale = 1;
            } else {
                $type_sale = 0;
                $fecha = $request->date_sale;
                $day = $request->plazo;
                $fechaActual = strtotime('+' . $day . ' day', strtotime($fecha));
                $expiration_date = date('Y-m-d', $fechaActual);
            }

  
            $hour = now()->isoFormat('H:mm:ss');

            $sale = Sale::create([
                'sale_number'  => $saleNumber,
                'cost'        => $request->costs ?? 0,
                'utility'      => $utility,
                'subtotal'     => $request->subtotal,
                'total_iva'          => $request->iva ?? 0,
                'total'        => $request->total,
                'balance'      => $balance,
                'hour'         => $hour,
                'date_sale'    => $request->date_sale,
                'term'         => $request->payment_form === 'credit' ? $request->plazo : 'null',
                'expiration_date' => $expiration_date,
                'type_sale'    => $type_sale,
                'payment_form' => $request->payment_form,
                'payment_method' => $request->payment_form === 'counted' ? $request->payment_method : 'null',
                'customer_id'  => $request->customer_id,
                'company_id'   => $company_id,
            ]);


            // 2. Guardar detalles y descontar stock
            foreach ($request->products as $index => $productId) {
                $quantity = $request->quantities[$index];
                $price    = $request->prices[$index];
                $tax      = $request->tax[$index];
                $cost     = $request->cost_product[$index];

                // Crear detalle
                SaleDetail::create([
                    'sale_id'   => $sale->id,
                    'product_id' => $productId,
                    'quantity'  => $quantity,
                    'price'     => $price,
                    'tax'       => $tax,
                    'cost'      => $cost,
                    'subtotal'  => $price * $quantity,
                    'company_id' => $company_id,
                ]);

                // Descontar stock
                $product = Product::find($productId);
                if ($product) {
                    if ($product->amount < $quantity) {
                        throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                    }
                    $product->amount -= $quantity;
                    $product->save();
                }
            }

            DB::commit();
            toastr()->success('Factura guardada correctamente.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage());
            die();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
    public function store22(Request $request)
    {


        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_type' => 'required|in:counted,credit',
            'issue_date' => 'nullable|date',
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
            var_dump($request->all());
            die();
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date_sale'   => 'required|date',
            'payment_form' => 'required|in:counted,credit',
            'subtotal'    => 'required|numeric|min:0',
            'iva'         => 'nullable|numeric|min:0',
            'total'       => 'required|numeric|min:0',
            'products'    => 'required|array|min:1',
            'products.*'  => 'exists:products,id',
            'quantities'  => 'required|array|min:1',
            'quantities.*' => 'numeric|min:1',
            'prices'      => 'required|array|min:1',
            'prices.*'    => 'numeric|min:0',
            'tax'         => 'required|array|min:1',
            'tax.*'       => 'numeric|min:0',
            'cost_product' => 'required|array|min:1',
            'cost_product.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $sale = Sale::with('details.product')->findOrFail($id);

            // 1️⃣ Restaurar stock previo
            foreach ($sale->details as $detail) {
                $detail->product->amount += $detail->quantity;
                $detail->product->save();
            }

            // 2️⃣ Eliminar detalles anteriores
            $sale->details()->delete();

            // 3️⃣ Actualizar venta
            $sale->update([
                'customer_id'  => $request->customer_id,
                'date_sale'    => $request->date_sale,
                'payment_form' => $request->payment_form,
                'payment_method' => $request->payment_form === 'counted' ? $request->payment_method : null,
                'plazo'        => $request->payment_form === 'credit' ? $request->plazo : null,
                'subtotal'     => $request->subtotal,
                'iva'          => $request->iva ?? 0,
                'total'        => $request->total,
                'cost'         => $request->costs ?? 0,
            ]);

            // 4️⃣ Insertar nuevos detalles y descontar stock
            foreach ($request->products as $index => $productId) {
                $quantity = $request->quantities[$index];
                $price    = $request->prices[$index];
                $tax      = $request->tax[$index];
                $cost     = $request->cost_product[$index];

                $sale->details()->create([
                    'product_id' => $productId,
                    'quantity'  => $quantity,
                    'price'     => $price,
                    'tax'       => $tax,
                    'cost'      => $cost,
                    'subtotal'  => $price * $quantity,
                ]);

                // Descontar nuevo stock
                $product = Product::find($productId);
                if ($product->amount < $quantity) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }
                $product->amount -= $quantity;
                $product->save();
            }

            DB::commit();

            return redirect()->route('sale.index')
                ->with('success', 'Factura actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}
