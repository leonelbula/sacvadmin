<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', Auth::user()->id)
            ->orderBy('full_name', 'asc')
            ->paginate(10);

        $title = "Lista de clientes";
        return view('customer.index', compact('customers', 'title'));
    }

    public function create()
    {
        $title = "Nuevo clientes";
        return view('customer.create', compact('title'));
    }

    public function store(CustomerRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->id;
            Customer::create($data);
            toastr()->success('Registro guardado');
            return back();
        } catch (Exception $e) {
            toastr()->error('Registro no guaedado');
            return back();
        }
    }

    public function show(Customer $customer)
    {
        $title = "Detalles";
        return view('customer.show', compact('customer', 'title'));
    }

    public function edit(Customer $customer)
    {
        $title = "Editar Cliente";
        return view('customer.edit', compact('customer', 'title'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            Customer::update($request->validated());
            toastr()->success('Registro guardado');
            return back();
        } catch (Exception $e) {
            toastr()->error('Registro no guardado');
            return back();
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            toastr()->success('Registro Eliminado');
            return redirect()->route('cliente.index');
        } catch (Exception $e) {
            toastr()->error('Registro no eliminado');
            return back();
        }
    }
}
