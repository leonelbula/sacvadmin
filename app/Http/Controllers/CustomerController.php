<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Departament;
use App\Models\City;
use App\Models\CustomerTributes;
use App\Models\IdentityDocument;
use App\Models\OrganizationType;
use App\Models\Tax;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $compania = Company::findOrFail(Auth::user()->company_id);

        $customers = $compania->customers()
            ->orderBy('full_name', 'asc')
            ->paginate(10);

        $title = "Lista de clientes";
        return view('customer.index', compact(
            'customers',
            'title'
        ));
    }

    public function search(Request $request)
    {
        $query = $request['q'];

        $clientes = Customer::with('city') // carga la relación con la ciudad
            ->where('full_name', 'LIKE', "%{$query}%")
            ->orWhere('identification_card', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json($clientes);
    }

    public function create()
    {
        $title = "Nuevo clientes";
        $departaments = Departament::all();
        $citys = City::all();
        $taxes = Tax::all();
        $organization_types = OrganizationType::all();
        $typeDocuments = IdentityDocument::all();
        $customerTribute = CustomerTributes::all();
        return view('customer.create', compact(
            'title',
            'departaments',
            'citys',
            'taxes',
            'organization_types',
            'typeDocuments',
            'customerTribute'
        ));
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $data['company_id'] = Auth::user()->company_id;

            Customer::create($data);
            DB::commit();
            toastr()->success('Cliente guardado correctamente');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar el cliente: ' . $e->getMessage());
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
        $departaments = Departament::all();
        $citys = City::all();
        $taxes = Tax::all();
        $organization_types = OrganizationType::all();
        $typeDocuments = IdentityDocument::all();
        $customerTribute = CustomerTributes::all();
        return view('customer.edit', compact(
            'customer',
            'title',
            'departaments',
            'citys',
            'taxes',
            'organization_types',
            'typeDocuments',
            'customerTribute'
        ));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->update($request->validated());
            DB::commit();
            toastr()->success('Registro guardado');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Registro no guardado' . $e->getMessage());
            return back();
        }
    }

    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();
            DB::commit();
            toastr()->success('Registro Eliminado');
            return redirect()->route('cliente.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Registro no eliminado' . $e->getMessage());
            return back();
        }
    }
}
