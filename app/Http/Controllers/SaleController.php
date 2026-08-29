<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Kardex;
use App\Models\Parameter;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\spent;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

use App\DTOs\SaleDTO;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');

        $title = "Lista de ventas";
        $sales = Sale::orderBy('id', 'DESC')
            ->paginate(10);
        $dataSales = $this->saleService->getPaginatedSales();
        return view('sale.index', compact('title', 'sales', 'search', 'dataSales'));
    }
    public function create()
    {
        $title = 'Nueva venta';
        $payments = PaymentMethod::all();
        $terms = Term::all();
        return view('sale.create', compact('title', 'terms', 'payments'));
    }

    /**
     * Almacena una nueva venta en el sistema.
     */
    public function store(Request $request): JsonResponse
    {
        // 1. Decodificar el String JSON de productos
        if (is_string($request->products)) {
            $request->merge([
                'products' => json_decode($request->products, true)
            ]);
        }

        // 2. Validación estricta adaptada a tus campos
        $validator = Validator::make($request->all(), [
            'customer_id'       => 'required|integer|exists:customers,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'payment_form'      => 'required|string|in:counted,credit', // counted = Contado, credit = Crédito
            'term'              => 'required_if:payment_form,credit|integer|min:0',
            'date_sale'         => 'required|date',
            'observation'       => 'nullable|string|max:150',
            'tax'               => 'integer',
            // Validación crucial para el array de productos (Carrito de compras)
            'products'          => 'required|array|min:1',
            'products.*.id'       => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price'    => 'required|numeric|min:0',
            'products.*.cost'     => 'required|numeric|min:0',
            'products.*.tax'      => 'required|numeric', // Ej: 19, 16, 0 (el porcentaje)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Errores de validación en el formulario.',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // 3. Construcción segura del DTO utilizando los datos validados
            // Pasamos el objeto $request al DTO como lo tienes definido en tu arquitectura
            $saleDto = SaleDTO::fromRequest($request);

            // 4. Obtener el listado limpio de productos directamente del Request
            $products = $request->input('products');

            // 5. Llamada al servicio enviando el DTO y los productos por separado
            $sale = $this->saleService->storeSale($saleDto, $products);

            // 6. Respuesta exitosa
            return response()->json([
                'status'  => 'success',
                'message' => 'Venta registrada exitosamente.',
                'data'    => [
                    'sale_id'     => $sale->id,
                    'sale_number' => $sale->sale_number,
                    'total'       => $sale->total,
                ]
            ], 201);
        } catch (Exception $e) {
            // 6. Control de errores (Atrapa falta de stock, impuestos no registrados, etc.)
            return response()->json([
                'status'  => 'error',
                'message' => 'No se pudo procesar la venta.',
                'errors'   => $e->getMessage() // En producción podrías querer ocultar mensajes técnicos no controlados
            ], 400);
        }
    }




    public function edit(Sale $sale)
    {
        $payments = PaymentMethod::all();
        $sale->load([
            'customer.city',
            'details.product',
            'details.tax',
        ]);
        return view('sale.edit', compact('sale', 'payments'));
    }
    public function update(Request $request, $id)
    {
        if (is_string($request->products)) {
            $request->merge([
                'products' => json_decode($request->products, true)
            ]);
        }
    dd($request->all());
        // 2. Validación estricta adaptada a tus campos
        $validator = Validator::make($request->all(), [
            'customer_id'       => 'required|integer|exists:customers,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'payment_form'      => 'required|string|in:counted,credit', // counted = Contado, credit = Crédito
            'term'              => 'required_if:payment_form,credit|integer|min:0',
            'date_sale'         => 'required|date',
            'observation'       => 'nullable|string|max:150',
            'tax'               => 'integer',
            // Validación crucial para el array de productos (Carrito de compras)
            'products'          => 'required|array|min:1',
            'products.*.id'       => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price'    => 'required|numeric|min:0',
            'products.*.cost'     => 'required|numeric|min:0',
            'products.*.tax'      => 'required|numeric', // Ej: 19, 16, 0 (el porcentaje)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Errores de validación en el formulario.',
                'errors'  => $validator->errors()
            ], 422);
        }
    }
    public function show(Sale $sale)
    {
        return view('sale.show', compact('sale'));
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

    public function print(Sale $sale)
    {
        $sale->load([
            'customer.city',
            'details.product',
        ]);

        $pdf = Pdf::loadView('sale.print', [

            'sale' => $sale,
        ])->setPaper('letter', 'portrait');

        return $pdf->stream("Factura_{$sale->sale_number}.pdf");
        return view('sale.print', compact('sale'));
    }


    public function ticket(Sale $sale)
    {
        $sale->load([
            'customer.city',
            'details.product',
        ]);

        $pdf = Pdf::loadView('sale.ticket', compact('sale'));

        // 80 mm de ancho
        $pdf->setPaper([0, 0, 226.77, 800], 'portrait');

        return $pdf->stream(
            'ticket-' . $sale->sale_number . '.pdf'
        );
    }
    public function ticketepson(Sale $sale)
    {

        $sale = Sale::with([
            'customer.city',
            'details.product'
        ])->findOrFail($sale->id);
        $company = Company::findOrFail(Auth::user()->company_id);
        $payments = PaymentMethod::all();
        $pdf = Pdf::loadView('pdf.ticketepson', [
            'company' => $company,
            'payments' => $payments,
            'sale' => $sale,
        ])->setPaper('letter', 'portrait');;

        return $pdf->stream("ticket_{$sale->sale_number}.pdf");
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
    public function report_sale()
    {
        $title = "Reporte de Ventas";
        $totalVentas = Sale::whereDate('date_sale', Carbon::today())
            ->sum('total');
        $totalUtilidad = Sale::whereDate('date_sale', Carbon::today())
            ->sum('utility');
        $totalDevoluciones = ReturnSale::whereDate('date_sale', Carbon::today())
            ->sum('total');
        $totalGastos = spent::whereDate('date_spent', Carbon::today())
            ->sum('total');
        return view(
            'sale.report_sale',
            compact(
                'title',
                'totalVentas',
                'totalUtilidad',
                'totalDevoluciones',
                'totalGastos'
            )
        );
    }
    public function reporte(Request $request)
    {
        // Validar rango de fechas
        $data = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'user_id'      => 'nullable|integer',
        ]);

        // Consulta con filtros
        $ventas = Sale::query()
            ->whereBetween('created_at', [
                $data['fecha_inicio'] . " 00:00:00",
                $data['fecha_fin'] . " 23:59:59"
            ])
            ->when($data['user_id'], function ($q) use ($data) {
                $q->where('user_id', $data['user_id']);
            })
            ->where('state', 1) // solo activas
            ->get();

        // Totales
        $total = $ventas->sum('total');

        // Generar PDF
        $pdf = Pdf::loadView('reports.sales', [
            'ventas' => $ventas,
            'total'  => $total,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => $data['fecha_fin'],
        ]);

        return $pdf->setPaper('letter')->stream('reporte_ventas.pdf');
    }
    public function reporteTotalesPorDia(Request $request)
    {
        $data = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'user_id'      => 'nullable|integer',
        ]);

        // Consulta agrupada por día
        $ventas = Sale::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->whereBetween('created_at', [
                $data['fecha_inicio'] . " 00:00:00",
                $data['fecha_fin'] . " 23:59:59"
            ])
            ->when($data['user_id'], function ($q) use ($data) {
                $q->where('user_id', $data['user_id']);
            })
            ->where('state', 1) // solo activas
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $granTotal = $ventas->sum('total');

        $pdf = Pdf::loadView('reports.sales_day', [
            'ventas' => $ventas,
            'granTotal' => $granTotal,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => $data['fecha_fin'],
        ]);

        return $pdf->setPaper('letter')->stream('reporte_totales_por_dia.pdf');
    }
}
/**
 * 
 * public function store(Request $request)
    {
        // 1. Validar los datos del JSON
        $validador = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'articulos' => 'required|array|min:1',
            'articulos.*.id' => 'required|exists:productos,id',
            'articulos.*.cantidad' => 'required|integer|min:1',
            'articulos.*.precio' => 'required|numeric|min:0',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validador->errors()
            ], 422);
        }

        // 2. Iniciar transacción para asegurar la integridad de los datos
        try {
            $resultado = DB::transaction(function () use ($request) {
                
                // Calcular el total de la factura sumando los subtotales
                $total = collect($request->articulos)->sum(function ($articulo) {
                    return $articulo['cantidad'] * $articulo['precio'];
                });

                // Crear la cabecera de la factura
                $factura = Factura::create([
                    'cliente_id' => $request->cliente_id,
                    'total' => $total,
                    'fecha' => now(), // o la fecha que envíes desde el frontend
                    'estado' => 'pagada'
                ]);

                // Guardar cada artículo en la tabla de detalles
                foreach ($request->articulos as $articulo) {
                    FacturaDetalle::create([
                        'factura_id' => $factura->id,
                        'producto_id' => $articulo['id'],
                        'cantidad' => $articulo['cantidad'],
                        'precio_unitario' => $articulo['precio'],
                        'subtotal' => $articulo['cantidad'] * $articulo['precio']
                    ]);
                    
                    // (Opcional) Aquí podrías restar el stock del producto si lo necesitas
                    // $producto = Producto::find($articulo['id']);
                    // $producto->decrement('stock', $articulo['cantidad']);
                }

                return $factura;
            });

            // 3. Responder al frontend con el éxito de la operación
            return response()->json([
                'success' => true,
                'message' => 'Factura creada exitosamente.',
                'factura_id' => $resultado->id
            ], 201);

        } catch (\Exception $e) {
            // Si algo falla dentro del DB::transaction, Laravel hace un Rollback automático
            return response()->json([
                'success' => false,
                'message' => 'No se pudo guardar la factura en el servidor.',
                'error' => $e->getMessage() // Quitar en producción por seguridad
            ], 500);
        }
    }

// ... dentro de tu FacturaController.php en el método store()

// Si la validación falla, NO usamos Toastr desde Laravel, mandamos el JSON con errores
if ($validador->fails()) {
    return response()->json([
        'success' => false,
        'errors' => $validador->errors()
    ], 422);
}

try {
    $resultado = DB::transaction(function () use ($request) {
        // ... (Tu lógica de guardado que hicimos antes)
        return $factura;
    });

    // AQUÍ USAS TU TOASTR DE LARAVEL
    // Se guarda en la sesión y se activará inmediatamente cuando JS redirija la página
    toastr()->success('Factura registrada y procesada con éxito');

    return response()->json([
        'success' => true,
        'factura_id' => $resultado->id
    ], 201);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error crítico en el servidor.'
    ], 500);
}


 */
