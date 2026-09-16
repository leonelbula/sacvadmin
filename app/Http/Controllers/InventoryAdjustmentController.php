<?php

namespace App\Http\Controllers;

use App\DTOs\InventoryAdjustmentDTO;
use App\Models\Product;
use App\Services\InventoryAdjustmentService;
use Illuminate\Http\Request;
use Throwable;

class InventoryAdjustmentController extends Controller
{
    public function __construct(
        protected InventoryAdjustmentService $service
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'movement_type' => $request->movement_type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        $adjustments = $this->service->search($filters);

        return view(
            'inventory.adjustments.index',
            compact('adjustments')
        );
    }

    public function create()
    {
        return view('inventory.adjustments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id'
            ],
            'movement_type' => [
                'required',
                'in:income,output'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'observation' => [
                'nullable',
                'string',
                'max:500'
            ],
        ]);

        try {

            $dto = InventoryAdjustmentDTO::fromRequest($request);

            $adjustment = $this->service->create($dto);

            toastr()->success('Ajuste de inventario registrado correctamente.');

            return redirect()
                ->route('inventory.adjustments.show', $adjustment->id);
        } catch (Throwable $e) {
            toastr()->error('Ajuste de inventario no registrado.');

            return back();
        }
    }

    public function show(int $id)
    {
        $adjustment = $this->service->findById($id);

        if (!$adjustment) {
            abort(404);
        }

        return view(
            'inventory.adjustments.show',
            compact('adjustment')
        );
    }
}
