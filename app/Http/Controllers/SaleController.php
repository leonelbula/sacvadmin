<?php

namespace App\Http\Controllers;


use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

use App\DTOs\SaleDTO;
use App\Services\ConfigurationService;
use App\Services\PosService;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService,
        protected PosService $pos_service,
        protected ConfigurationService $configuration_service
    ) {}

    public function index(Request $request)
    {
        $search = $request->all();

        $user = Auth::user();
        $posActive = $this->pos_service->posActive($user->id);

        if ($user->type != 'admin') {
            if (isset($posActive) && $posActive->state == 1) {
                $tbnSale = true;
            } else {
                $tbnSale = false;
            }
        } else {
            $tbnSale = true;
        }


        if (isset($search['customer_name']) || isset($search['sale_number']) || isset($search['payment_form']) || isset($search['date_from']) || isset($search['date_to'])) {
            $dataSales = $this->saleService->searchSales($search);
        } else {
            $dataSales = $this->saleService->getPaginatedSales();
        }

        $title = "Lista de ventas";
        return view('sale.index', compact('title', 'dataSales', 'tbnSale'));
    }
    public function searchSale(int $saleNumber): JsonResponse
    {
        $sale = $this->saleService->findBySaleNumber($saleNumber);

        if (!$sale) {
            return response()->json([
                'message' => 'Venta no encontrada.'
            ], 404);
        }

        return response()->json($sale);
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
    public function update(Request $request, int $id)
    {
        /*
    |--------------------------------------------------------------------------
    | Decodificar productos
    |--------------------------------------------------------------------------
    */

        if (is_string($request->products)) {
            $products = json_decode($request->products, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Los productos enviados no tienen un formato válido.',
                ], 422);
            }

            $request->merge([
                'products' => $products
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Validación
    |--------------------------------------------------------------------------
    */

        $validator = Validator::make($request->all(), [

            'customer_id' =>
            'required|integer|exists:customers,id',

            'payment_method_id' =>
            'required|integer|exists:payment_methods,id',

            'payment_form' =>
            'required|string|in:counted,credit',

            'term' =>
            'required_if:payment_form,credit|integer|min:0',

            'date_sale' =>
            'required|date',

            'observation' =>
            'nullable|string|max:150',

            'tax' =>
            'nullable|integer',

            'products' =>
            'required|array|min:1',

            'products.*.id' =>
            'required|integer|exists:products,id',

            'products.*.quantity' =>
            'required|integer|min:1',

            'products.*.price' =>
            'required|numeric|min:0',

            'products.*.cost' =>
            'required|numeric|min:0',

            'products.*.tax' =>
            'required|numeric|min:0',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Errores
    |--------------------------------------------------------------------------
    */

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Errores de validación en el formulario.',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {

            /*
        |--------------------------------------------------------------------------
        | DTO
        |--------------------------------------------------------------------------
        */

            $saleDto = SaleDTO::fromRequest($request);

            /*
        |--------------------------------------------------------------------------
        | Productos validados
        |--------------------------------------------------------------------------
        */

            $products = $request->input('products');

            /*
        |--------------------------------------------------------------------------
        | Actualizar venta existente
        |--------------------------------------------------------------------------
        */

            $sale = $this->saleService->updateSale(
                $id,
                $saleDto,
                $products
            );

            /*
        |--------------------------------------------------------------------------
        | Respuesta
        |--------------------------------------------------------------------------
        */

            return response()->json([
                'status'  => 'success',
                'message' => 'Venta actualizada exitosamente.',
                'data'    => [
                    'sale_id'     => $sale->id,
                    'sale_number' => $sale->sale_number,
                    'total'       => $sale->total,
                ]
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'No se pudo actualizar la venta.',
                'errors'   => $e->getMessage()
            ], 400);
        }
    }
    public function show(Sale $sale)
    {
        return view('sale.show', compact('sale'));
    }
    public function destroy($id)
    {

        try {

            $this->saleService->deleteSale($id);

            toastr()->success('Factura eliminada correctamente.');
            return redirect()->route('sale.index');
        } catch (\Exception $e) {

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

        $company = $this->configuration_service->getCompany();
        $pdf = Pdf::loadView('sale.print', [
            'company' => $company,
            'sale' => $sale,
        ])->setPaper('letter', 'portrait');

        return $pdf->stream("Factura_{$sale->sale_number}.pdf");
        //return view('sale.print', compact('sale'));
    }


    public function ticket(Sale $sale)
    {
        $sale->load([
            'customer.city',
            'details.product',
        ]);

        $company = $this->configuration_service->getCompany();

        $pdf = Pdf::loadView('sale.ticket', compact('sale', 'company'));

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
        $company = $this->configuration_service->getCompany();
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
        $company = $this->configuration_service->getCompany()();
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
