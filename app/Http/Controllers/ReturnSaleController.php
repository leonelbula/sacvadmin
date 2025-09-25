<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\ReturnSale;
use App\Models\ReturnSaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class ReturnSaleController extends Controller
{
    public function index()
    {
        $title = "Lista de Devoluciones";
        $returnsales = ReturnSale::orderBy('id', 'DESC')->get();
        return view('returnsale.index', compact('title', 'returnsales'));
    }
    public function create()
    {
        $title = 'Nueva Devolucion';

        return view('returnsale.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'reason'      => 'required',
            'date_sale'   => 'required|date',
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
            $user_id = Auth::user()->id;
            $company_id = Auth::user()->company_id;
            $compania = Company::findOrFail($company_id);
            $last_sale = ReturnSale::where('company_id', $company_id)
                ->orderBy('id', 'desc')
                ->first();
            $parameter = $compania->parameters()->first();

            if ($last_sale) {
                $returnsaleNumber = $last_sale->returnsale_number + 1;
            } else {
                $returnsaleNumber = 1;
            }

            $cost = $request->costs;
            $utility = $request->total - $request->costs;


            $hour = now()->isoFormat('H:mm:ss');

            $returnsale = ReturnSale::create([
                'returnsale_number'  => $returnsaleNumber,
                'cost'        => $request->costs ?? 0,
                'utility'      => $utility,
                'subtotal'     => $request->subtotal,
                'total_iva'          => $request->iva ?? 0,
                'total'        => $request->total,
                'hour'         => $hour,
                'date_sale'    => $request->date_sale,
                'reason'       => $request->reason,
                'customer_id'  => $request->customer_id,
                'company_id'   => $company_id,
                'user_id'      => $user_id,
            ]);


            // 2. Guardar detalles y agregar stock
            foreach ($request->products as $index => $productId) {
                $quantity = $request->quantities[$index];
                $price    = $request->prices[$index];
                $tax      = $request->tax[$index];
                $cost     = $request->cost_product[$index];

                // Crear detalle
                ReturnSaleDetail::create([
                    'return_sale_id'   => $returnsale->id,
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
                    $product->amount += $quantity;
                    $product->save();
                }
            }

            DB::commit();
            toastr()->success('Factura guardada correctamente.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion' . $e->getMessage());
            //dd($e->getMessage());
            return back();
        }
    }

    public function edit(ReturnSale $returnsale)
    {
        $title = "Editar ventas";

        $returnsale = ReturnSale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($returnsale->id);

        $lineItems = $returnsale->details->map(function ($d) {
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


        return view('returnsale.edit', compact('returnsale', 'title', 'lineItems'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'reason'      => 'required',
            'date_sale'   => 'required|date',
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
            $retunsale = ReturnSale::with('details.product')->findOrFail($id);
            $company_id = Auth::user()->company_id;

            // 1️⃣ Restaurar stock previo
            foreach ($retunsale->details as $detail) {
                $detail->product->amount -= $detail->quantity;
                $detail->product->save();
            }


            // 2️⃣ Eliminar detalles anteriores
            $retunsale->details()->delete();



            $cost = $request->costs;
            $utility = $request->total - $request->costs;


            // 3️⃣ Actualizar venta
            $retunsale->update([
                'cost'        => $request->costs ?? 0,
                'utility'      => $utility,
                'subtotal'     => $request->subtotal,
                'total_iva'          => $request->iva ?? 0,
                'total'        => $request->total,
                'date_sale'    => $request->date_sale,
                'reason'       => $request->reason,
                'customer_id'  => $request->customer_id,
            ]);

            // 4️⃣ Insertar nuevos detalles y descontar stock
            foreach ($request->products as $index => $productId) {
                $quantity = $request->quantities[$index];
                $price    = $request->prices[$index];
                $tax      = $request->tax[$index];
                $cost     = $request->cost_product[$index];

                ReturnSaleDetail::create([
                    'return_sale_id'   => $retunsale->id,
                    'product_id' => $productId,
                    'quantity'  => $quantity,
                    'price'     => $price,
                    'tax'       => $tax,
                    'cost'      => $cost,
                    'subtotal'  => $price * $quantity,
                    'company_id' => $company_id,
                ]);

                // Aumentar nuevo stock
                $product = Product::find($productId);
                $product->amount += $quantity;
                $product->save();
            }

            DB::commit();
            toastr()->success('Devolucion actualizada correctamente.');
            return redirect()->route('returnsale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion' . $e->getMessage());
            return back();
        }
    }

    public function show(ReturnSale $returnsale)
    {
        $title = "Ver Factura";

        $returnsale = ReturnSale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($returnsale->id);

        $lineItems = $returnsale->details->map(function ($d) {
            return [
                'id'             => (int) $d->product_id,
                'name'           => (string) $d->product->name,
                'price'          => (int) $d->price,
                'cost'           => (int) $d->cost,
                'iva'            => (int) $d->tax,                // por compatibilidad con tu create
                'tax'            => (int) $d->tax,                // lo usas en la tabla
                'quantity'       => (int) $d->quantity,
                'stock'          => (int) ($d->product->amount ?? 0),
            ];
        })->values()->toArray();


        // Métodos de pago

        return view('returnsale.show', compact('returnsale', 'title', 'lineItems'));
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $returnsale = ReturnSale::with('details.product')->findOrFail($id);

            // 1️⃣ Restaurar stock previo
            foreach ($returnsale->details as $detail) {
                $detail->product->amount -= $detail->quantity;
                $detail->product->save();
            }
            // 2️⃣ Eliminar detalles anteriores
            $returnsale->details()->delete();
            $returnsale->delete();
            DB::commit();
            toastr()->success('Devolucion eliminada correctamente.');
            return redirect()->route('returnsale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al eliminar la devolucion' . $e->getMessage());
            return back();
        }
    }
      public function ticket(ReturnSale $returnsale)
    {

        $returnsale = ReturnSale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($returnsale->id);
        $company = Company::findOrFail(Auth::user()->company_id);
        $pdf = Pdf::view('pdf.ticketdevol', [
            'company' => $company,
            'returnsale' => $returnsale,
        ])  ->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->margins(2, 2, 2, 2) // mm
                ->setOption('width', '80mm')   // 👈 ancho fijo de ticket
                ->setOption('height', '200mm'); // puedes poner 'auto', pero a veces necesita un valor
        });
        return $pdf->inline("ticket_{$returnsale->returnsale_number}.pdf");
    }
}
