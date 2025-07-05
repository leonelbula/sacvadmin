<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Proveedores";
        $suppliers = Supplier::orderBy('full_name','asc')->paginate(10);
        return view('supplier.index', compact('title', 'suppliers'));
    }
    public function create()
    {
        $title = "Nuevo proveedor";
        return view('supplier.create', compact('title'));
    }

    public function store(SupplierRequest $request)
    {
        Supplier::create($request->validated());
        toastr()->success('Registro guardado');
        return back();
    }

    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $title = "Editar Cliente";
        return view('supplier.edit', compact('supplier', 'title'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'full_name' => 'required|string',
            'identification_card' => 'required',
            'address' => 'required|string',
            'department' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'credit_amount' => 'required',

        ]);

        $supplier->full_name = $request->full_name;
        $supplier->identification_card = $request->identification_card;
        $supplier->address = $request->address;
        $supplier->department = $request->department;
        $supplier->city = $request->city;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->credit_amount = $request->credit_amount;
        $supplier->description = $request->description;

        $supplier->save();

        return redirect()->route('proveedor.index');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('proveedor.index');
    }
}
