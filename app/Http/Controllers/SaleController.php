<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

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
            var_dump($parameter);
            if ($last_sale) {
                $saleNumber = $last_sale->sale_number + 1;
            } else {
                if ($parameter == null) {
                    $saleNumber =  1;
                } else {

                    $saleNumber = $parameter->sale_code + 1;
                }
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
                $payment_form = 1;
            } else {
                $payment_form = 0;
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
                'payment_form' => $request->payment_form === 'counted' ? $request->payment_form : 'credit',
                'payment_method' => $request->payment_form === 'counted' ? $request->payment_method : null,
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
            toastr()->error('Error al guardar la informacion');
            dd($e->getMessage());
            //return back();
        }
    }

    public function edit(Sale $sale)
    {
        $title = "Editar ventas";
        $terms = Term::all();
        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);

        $lineItems = $sale->details->map(function ($d) {
            return [
                'id'             => (int) $d->product_id,
                'name'           => (string) $d->product->name,
                'price'          => (int) $d->price,
                'original_price' => (int) $d->price,
                'cost'           => (int) $d->cost,
                'iva'            => (int) $d->tax,                // por compatibilidad con tu create
                'tax'            => (int) $d->tax,                // lo usas en la tabla
                'quantity'       => (int) $d->quantity,
                'stock'          => (int) ($d->product->amount ?? 0),
            ];
        })->values()->toArray();


        // Métodos de pago
        $payments = PaymentMethod::all();
        return view('sale.edit', compact('payments', 'sale', 'terms', 'title', 'lineItems'));
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
            $company_id = Auth::user()->company_id;

            // 1️⃣ Restaurar stock previo
            foreach ($sale->details as $detail) {
                $detail->product->amount += $detail->quantity;
                $detail->product->save();
            }


            // 2️⃣ Eliminar detalles anteriores
            $sale->details()->delete();



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

            // 3️⃣ Actualizar venta
            $sale->update([
                'cost'         => $request->costs ?? 0,
                'utility'      => $utility,
                'subtotal'     => $request->subtotal,
                'total_iva'    => $request->iva ?? 0,
                'total'        => $request->total,
                'balance'      => $balance,
                'date_sale'    => $request->date_sale,
                'term'         => $request->payment_form === 'credit' ? $request->plazo : 'null',
                'expiration_date' => $expiration_date,
                'type_sale'    => $type_sale,
                'payment_form' =>  $request->payment_form === 'counted' ? $request->payment_form : 'credit',
                'payment_method' => $request->payment_form === 'counted' ? $request->payment_method : null,
                'customer_id'  => $request->customer_id,
            ]);

            // 4️⃣ Insertar nuevos detalles y descontar stock
            foreach ($request->products as $index => $productId) {
                $quantity = $request->quantities[$index];
                $price    = $request->prices[$index];
                $tax      = $request->tax[$index];
                $cost     = $request->cost_product[$index];

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

                // Descontar nuevo stock
                $product = Product::find($productId);
                if ($product->amount < $quantity) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }
                $product->amount -= $quantity;
                $product->save();
            }

            DB::commit();
            toastr()->success('Factura actualizada correctamente.');
            return redirect()->route('sale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion' . $e->getMessage());
            return back();
        }
    }
    public function show(Sale $sale)
    {
        $title = "Ver Factura";
        $terms = Term::all();
        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);

        $lineItems = $sale->details->map(function ($d) {
            return [
                'id'             => (int) $d->product_id,
                'name'           => (string) $d->product->name,
                'price'          => (int) $d->price,
                'original_price' => (int) $d->price,
                'cost'           => (int) $d->cost,
                'iva'            => (int) $d->tax,                // por compatibilidad con tu create
                'tax'            => (int) $d->tax,                // lo usas en la tabla
                'quantity'       => (int) $d->quantity,
                'stock'          => (int) ($d->product->amount ?? 0),
            ];
        })->values()->toArray();


        // Métodos de pago
        $payments = PaymentMethod::all();
        return view('sale.show', compact('payments', 'sale', 'terms', 'title', 'lineItems'));
    }
    public function destroy($id)
    {
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
            $sale->delete();
            DB::commit();
            toastr()->success('Factura eliminada correctamente.');
            return redirect()->route('sale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al eliminar la factura' . $e->getMessage());
            return back();
        }
    }
    public function invocesPdf(Sale $sale)
    {

        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);
        $company = Company::findOrFail(Auth::user()->company_id);
        $payments = PaymentMethod::all();
        $pdf = Pdf::view('pdf.invoice', [
            'company' => $company,
            'payments' => $payments,
            'sale' => $sale,
        ])->format('Letter') // 👈 Aquí defines tamaño Carta
            ->margins(5, 5, 5, 5); // (arriba, derecha, abajo, izquierda) opcional;
        return $pdf->inline("Factura_{$sale->sale_number}.pdf");
    }
    public function ticket(Sale $sale)
    {

        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);
        $company = Company::findOrFail(Auth::user()->company_id);
        $payments = PaymentMethod::all();
        $pdf = Pdf::view('pdf.ticket', [
            'company' => $company,
            'payments' => $payments,
            'sale' => $sale,
        ])->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->margins(2, 2, 2, 2) // mm
                ->setOption('width', '80mm')   // 👈 ancho fijo de ticket
                ->setOption('height', '200mm'); // puedes poner 'auto', pero a veces necesita un valor
        });
        return $pdf->inline("ticket_{$sale->sale_number}.pdf");
    }
    public function downloadInvoice($sale)
    {
        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);
        $company = Company::findOrFail(Auth::user()->company_id);
        $payments = PaymentMethod::all();
        $pdf = Pdf::view('pdf.factura', [
            'company' => $company,
            'payments' => $payments,
            'sale' => $sale,
        ]);
        // Descargar directamente
        return $pdf->download("Factura_{$sale->sale_number}.pdf");
    }
}
