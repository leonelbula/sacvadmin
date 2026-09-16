<?php

namespace App\Http\Controllers;

use App\DTOs\SaleReturnDTO;
use App\Services\SaleReturnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleReturnController extends Controller
{
    public function __construct(protected SaleReturnService $saleReturnService) {}

    public function index(Request $request)
    {

        if (!empty($request->all())) {
            $returns = $this->saleReturnService->search($request->all());
        } else {
            $returns = $this->saleReturnService->getAllReturns();
            //$totalProducts = $returns->details->count();
        }

       return view('returnsale.index', compact('returns'));
    }
    public function create()
    {
        return view('returnsale.create');
    }
    public function store(Request $request)
    {

        if (is_string($request->products)) {
            $request->merge([
                'products' => json_decode($request->products, true)
            ]);
        }

        $validated = Validator::make($request->all(), [

            'total' => 'required|numeric',
            'reason' => 'required|string|max:255',
            'refund_type' => 'required|string|max:255',
            'observation' => 'nullable|string|max:255',

            'products'          => 'required|array|min:1',
            'products.*.id'       => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price'    => 'required|numeric|min:0',
            'products.*.cost'     => 'required|numeric|min:0',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Errores de validación en el formulario.',
                'errors'  => $validated->errors()
            ], 422);
        }

        try {
            $saleReturnRequest = SaleReturnDTO::fromRequest($request);
            $products = $request->input('products', []);

            $saleReturn = $this->saleReturnService->createReturn($saleReturnRequest, $products);
            return response()->json([
                'status'  => 'success',
                'message' => 'Venta registrada exitosamente.',
                'data'    => [
                    'return_number_id'     => $saleReturn->id,
                    'return_number' => $saleReturn->return_number,
                    'total'       => $saleReturn->total,
                ]
            ], 201);

            /*toastr()->success('Devolución creada exitosamente.');
            return redirect()->route('salereturn.index');*/
        } catch (\Exception $e) {
            toastr()->error('Error al crear la devolución: ' . $e->getMessage());

            return back();


            //return redirect()->route('returnsale.index')->with('success', 'Devolución creada exitosamente.');
        }
    }
    public function show($id)
    {
        $returnSale = $this->saleReturnService->getReturnById($id);

        return view('returnsale.show', compact('returnSale'));
    }

    public function destroy($id)
    {
        try {
            $this->saleReturnService->deleteReturn($id);
            toastr()->success('Devolución eliminada exitosamente.');
            return redirect()->route('salereturn.index');
        } catch (\Exception $e) {
            toastr()->error('Error al eliminar la devolución: ' . $e->getMessage());
            return back();
        }
    }
}
