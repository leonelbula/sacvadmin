<?php

namespace App\Http\Controllers;

use App\DTOs\ShoppingDTO;
use App\Models\Company;
use App\Models\Product;
use App\Models\Shopping;
use App\Services\ShoppingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    public function __construct(
        protected ShoppingService $shoppiong_service
    ) {}

    public function index(): View
    {

        $shoppings = $this->shoppiong_service->All();
        //dd($shoppings['total']);
        return view('shopping.index', [
            'shoppings' => $shoppings['shoppings'],
            'total' => $shoppings['total'],
            'balance' => $shoppings['balance']
        ]);
    }
    public function create(): View
    {
        return view('shopping.create');
    }
    public function store(Request $request)
    {


        if (is_string($request->products)) {
            $request->merge([
                'products' => json_decode($request->products, true)
            ]);
        }



        $validator = Validator::make($request->all(), [
            'supplier_id'       => 'required|integer|exists:suppliers,id',
            'purchase_type'      => 'required|string|in:counted,credit', // counted = Contado, credit = Crédito
            'term'              => 'integer|min:0',
            'shopping_date'         => 'required|date',
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

            $shoppingDto = ShoppingDTO::fromRequest($request);

            $products = $request->input('products');

            $shopping = $this->shoppiong_service->storeShopping($shoppingDto, $products);

            // 6. Respuesta exitosa
            return response()->json([
                'status' => 'success',
                'message' => 'Compra actualizada exitosamente.',
                'data' => [
                    'shopping_id' => $shopping->id,
                    'shopping_nombre' => $shopping->invoice_number,
                    'total' => $shopping->total,
                ],
                'redirect' => route('shopping.index'),
            ], 200);
        } catch (Exception $e) {
            // 6. Control de errores (Atrapa falta de stock, impuestos no registrados, etc.)
            return response()->json([
                'status'  => 'error',
                'message' => 'No se pudo procesar la compra.',
                'errors'   => $e->getMessage() // En producción podrías querer ocultar mensajes técnicos no controlados
            ], 400);
        }
    }
    public function show(Shopping $shopping)
    {
        $shopping->load('details.product', 'supplier');
        return view('shopping.show', compact('shopping'));
    }
    public function edit(Shopping $shopping)
    {
        $shopping->load([
            'supplier',
            'details.product'

        ]);
        return view('shopping.edit', compact('shopping'));
    }
    public function update(Request $request, $id)
    {

        if (is_string($request->products)) {
            $request->merge([
                'products' => json_decode($request->products, true)
            ]);
        }

        $validator = Validator::make($request->all(), [
            'supplier_id'       => 'required|integer|exists:suppliers,id',
            'purchase_type'      => 'required|string|in:counted,credit', // counted = Contado, credit = Crédito
            'term'              => 'integer|min:0',
            'shopping_date'         => 'required|date',
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

            $shoppingDto = ShoppingDTO::fromRequest($request);

            $products = $request->input('products');

            $shopping = $this->shoppiong_service->updateShopping($id, $shoppingDto, $products);

            // 6. Respuesta exitosa
            return response()->json([
                'status'  => 'success',
                'message' => 'Compra Actualizada exitosamente.',
                'data'    => [
                    'shopping_id'     => $shopping->id,
                    'shopping_nombre' => $shopping->invoice_number,
                    'total'       => $shopping->total,
                ]
            ], 201);
        } catch (Exception $e) {
            // 6. Control de errores (Atrapa falta de stock, impuestos no registrados, etc.)
            return response()->json([
                'status'  => 'error',
                'message' => 'No se pudo procesar la actulizacion de compra.',
                'errors'   => $e->getMessage() // En producción podrías querer ocultar mensajes técnicos no controlados
            ], 400);
        }
    }
    public function destroy($id)
    {
        try {
            $result = $this->shoppiong_service->deleteShopping($id);
            if ($result) {
                toastr()->success('Compra eliminada correctamente.');
                return redirect()->route('shopping.index');
            }
            toastr()->error('Compra no eliminada.');
            return redirect()->route('shopping.index');
        } catch (Exception $e) {
            //throw $th;
            toastr()->error('Error al eliminar la compra' . $e->getMessage());
            return back();
        }
    }
}
