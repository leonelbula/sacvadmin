<?php

namespace App\Http\Controllers;

use App\DTOs\SupplierDTO;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;


class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $supplier_service
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $suppliers = $this->supplier_service->search($search);
        } else {
            $suppliers = $this->supplier_service->All();
        }


        return view('supplier.index', compact('suppliers'));
    }
    public function search(string $query)
    {

        $suppliers =  $this->supplier_service->search($query);

        return response()->json($suppliers);
    }
    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data = SupplierDTO::fromRequest($request);
        $supplier = $this->supplier_service->create($data);
        if ($supplier) {
            toastr()->success('Proveedor registro corectamente');
            return back();
        }
        toastr()->error('Registro no guardado');
        return back();
    }

    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    public function edit(int $id)
    {
        $supplier = $this->supplier_service->find($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {

         $request->validate([
            'full_name' => 'required|string',
            'identification' => 'required',
            'address' => 'required|string',
            'department' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
        ]);



        $data = SupplierDTO::fromRequest($request);

        $supplier = $this->supplier_service->update($id, $data);
        if ($supplier) {
            toastr()->success('Proveedor Actulizado corectamente');
            return back();
        }

        toastr()->success('Registro Guardado');
        return back();
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        toastr()->success('Registro Eliminado');
        return redirect()->route('supplier.index');
    }
}
