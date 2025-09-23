<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{

    public function index()
    {
        $title = "Proveedores";
        $company = Company::findOrFail(Auth::user()->company_id);

        $suppliers = $company->suppliers()
            ->orderBy('full_name', 'asc')
            ->paginate(10);
        return view('supplier.index', compact('title', 'suppliers'));
    }
    public function search(Request $request)
    {
        $query = $request['q'];

        $suppliers =  Supplier::where('company_id', Auth::user()->company_id)
            ->where('full_name', 'LIKE', "%{$query}%")
            ->orWhere('identification_card', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json($suppliers);
    }
    public function create()
    {
        $title = "Nuevo proveedor";
        return view('supplier.create', compact('title'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($data['description'] == '') {
            $data['description']  = 'N/N';
        }

        if ($data['credit_amount'] == '') {
            $data['credit_amount'] = 0;
        }
        $data['company_id'] = Auth::user()->company_id;
        Supplier::create($data);
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
            'Departament' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        if ($request->description == '') {
            $description = 'N/N';
        } else {
            $description = $request->description;
        }

        if ($request->credit_amount == '') {
            $credit_amount = 0;
        } else {
            $credit_amount = $request->credit_amount;
        }

        $supplier->full_name = $request->full_name;
        $supplier->identification_card = $request->identification_card;
        $supplier->address = $request->address;
        $supplier->Departament = $request->Departament;
        $supplier->city = $request->city;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->credit_amount = $credit_amount;
        $supplier->description = $description;


        $supplier->save();
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
