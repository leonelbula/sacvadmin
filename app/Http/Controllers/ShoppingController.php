<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function index(): View
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        $shopping = $company->shopping()->paginate(10);
        $title = 'Lista de Compras';
        return view('shopping.index', ['shopping' => $shopping, 'title' => $title]);
    }
    public function create(): View
    {
        $title = 'Nueva Compra';
        $company = Company::findOrFail(Auth::user()->company_id);
        $suppliers = $company->suppliers()
            ->orderBy('full_name', 'asc')->get();
        $products = $company->products()
            ->orderBy('name', 'asc')->get();
        return view('shopping.create', ['title' => $title, 'suppliers' => $suppliers, 'products' => $products]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|string|max:50',
            'payment_form' => 'required|in:credit,counted',
            'due_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'prices' => 'required|array',
            'prices.*' => 'numeric|min:0',
            'tax'         => 'required|array|min:1',
            'tax.*'       => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $iva_total = 0;
            $total = 0;

            $details = [];

            foreach ($request->products as $index => $product_id) {

                $product = Product::find($product_id);


                $quantity = $request->quantities[$index];
                $price = $request->prices[$index];
                $has_iva = isset($request->ivas[$index]);

                $line_subtotal = $quantity * $price;
                $line_iva = $has_iva ? $line_subtotal * 0.19 : 0;
                $line_total = $line_subtotal + $line_iva;

                $subtotal += $line_subtotal;
                $iva_total += $line_iva;
                $total += $line_total;


                $amount_product = $product->amount;
                $new_amount = $quantity + $amount_product;
                //let valor = Number(($cost.value * $utility.value) / 100);
                // let precio = Number($cost.value) + valor;
                $valor = ($price * $product->utility) / 100;
                $newPrice = $price + $valor;

                $product->cost = $price;
                $product->price = $newPrice;
                $product->amount = $new_amount;


                $product->save();


                $details[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'has_iva' => $has_iva,
                    'subtotal' => $line_subtotal,
                    'iva' => $line_iva,
                    'total' => $line_total,
                    'company_id' => Auth::user()->company_id,
                ];
            }
            if ($request->payment_form == 'counted') {
                $due_date = $request->date_sale;
            } else {

                $fecha = $request->date_sale;
                $day = $request->plazo;
                $fechaActual = strtotime('+' . $day . ' day', strtotime($fecha));
                $due_date = date('Y-m-d', $fechaActual);
            }
            $shopping = Shopping::create([
                'invoice_number' => $request->invoice_number,
                'shopping_date' => $request->date_sale,
                'purchase_type' => $request->payment_form,
                'subtotal' => $subtotal,
                'iva' => $iva_total,
                'total' => $total,
                'balance' => $total,
                'due_date' => $due_date,
                'supplier_id' => $request->supplier_id,
                'company_id' => Auth::user()->company_id,
                'user_id' => Auth::user()->id,
            ]);

            foreach ($details as $detail) {
                //$shopping->details()->createMany($details);
                $shopping->details()->create($detail);
            }

            DB::commit();

            toastr()->success('Compra registrada exitosamente.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la compra: ' . $e->getMessage());
            return back();
        }
    }
    public function show(Shopping $shopping)
    {
        $shopping->load('details.product', 'supplier');
        return view('shopping.show', compact('shopping'));
    }
    public function edit(Shopping $shopping)
    {
        if ($shopping->company_id == Auth::user()->company_id) {
            $company = Company::findOrFail(Auth::user()->company_id);
            $shopping = Shopping::with([
                'supplier',
                'details.product'
            ])->findOrFail($shopping->id);

            $lineItems = $shopping->details->map(function ($d) {
                return [
                    'id'             => (int) $d->product_id,
                    'name'           => (string) $d->product->name,
                    'cost'           => (int) $d->price,
                    'iva'            => (int) $d->iva,                // por compatibilidad con tu create
                    'tax'            => (int) $d->has_iva,                // lo usas en la tabla
                    'quantity'       => (int) $d->quantity,
                    'stock'          => (int) ($d->product->quantity ?? 0),
                ];
            })->values()->toArray();


            return view('shopping.edit', compact('shopping','lineItems'));
        } else {
            return redirect()->route('shopping.index');
        }
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|string|max:50',
            'payment_form' => 'required|in:credit,counted',
            'due_date' => 'nullable|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'prices' => 'required|array',
            'prices.*' => 'numeric|min:0',
            'tax'         => 'required|array|min:1',
            'tax.*'       => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $shopping = Shopping::with('details')->findOrFail($id);

            // RESTAR STOCK DE DETALLES ANTERIORES
            foreach ($shopping->details as $oldDetail) {
                $product = Product::find($oldDetail->product_id);
                if ($product) {
                    $product->amount -= $oldDetail->quantity;
                    $product->save();
                }
            }

            // Eliminar detalles antiguos
            $shopping->details()->delete();

            $subtotal = 0;
            $iva_total = 0;
            $total = 0;
            $details = [];

            foreach ($request->products as $index => $product_id) {
                $quantity = $request->quantities[$index];
                $price = $request->prices[$index];
                $has_iva = isset($request->ivas[$index]);

                $line_subtotal = $quantity * $price;
                $line_iva = $has_iva ? $line_subtotal * 0.19 : 0;
                $line_total = $line_subtotal + $line_iva;

                $subtotal += $line_subtotal;
                $iva_total += $line_iva;
                $total += $line_total;

                $details[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'has_iva' => $has_iva,
                    'subtotal' => $line_subtotal,
                    'iva' => $line_iva,
                    'total' => $line_total,
                    'company_id' => Auth::user()->company_id,
                ];

                // ACTUALIZAR STOCK Y PRECIO DEL PRODUCTO
                $product = Product::find($product_id);
                if ($product) {
                    $product->amount += $quantity;
                    $product->price = $price;
                    $product->save();
                }
            }

            $shopping->update([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => $request->invoice_number,
                'purchase_type' => $request->purchase_type,
                'due_date' => $request->purchase_type == 'credito' ? $request->due_date : null,
                'subtotal' => $subtotal,
                'iva' => $iva_total,
                'total' => $total,
            ]);

            $shopping->details()->createMany($details);

            DB::commit();
            toastr()->success('Compra actualizada correctamente.');
            return redirect()->route('shopping.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al actualizar la compra: ' . $e->getMessage());
            return back();
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $shopping = Shopping::with('details')->findOrFail($id);

            // Revertir stock de los productos
            foreach ($shopping->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->amount -= $detail->quantity;
                    if ($product->amount < 0) {
                        $product->amount = 0;
                    }
                    $product->save();
                }
            }

            // Laravel eliminará detalles automáticamente si hay relación con cascade
            $shopping->delete();

            DB::commit();
            toastr()->success('Compra eliminada correctamente.');
            return redirect()->route('shopping.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al eliminar la compra: ' . $e->getMessage());
            return back();
        }
    }
}
