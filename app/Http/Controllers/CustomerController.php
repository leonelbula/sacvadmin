<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;

use App\Models\Customer;
use App\Models\Departament;
use App\Models\City;
use App\Models\CustomerTributes;
use App\Models\IdentityDocument;
use App\Models\OrganizationType;
use App\Models\Tax;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Interfaces\CustomerRepositoryInterface;
use App\DTOs\CustomerDTO;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService,
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function index( Request $request)
    {
         $search = $request->input('search');
        $customers = $this->customerService->all();

        $title = "Lista de clientes";
        return view('customer.index', compact(
            'customers',
            'title',
            'search'
        ));
    }

    public function search(Request $request)
    {
        $query = $request['q'];

        $clientes = $this->customerService->search($query);

        return response()->json($clientes);
    }

    public function create()
    {
        $title = "Nuevo clientes";
        
        return view('customer.create', compact(
            'title'
        ));
    }

    public function store(CustomerRequest $request)
    {
        $data = CustomerDTO::fromRequest($request);
        $customer = $this->customerService->create($data);
        if ($customer) {
            toastr()->success('Cliente guardado correctamente');
        } else {
            toastr()->error('Error al guardar el cliente');
        }
        return back();
    }

    public function show(Customer $customer)
    {
        $title = "Detalles";
        return view('customer.show', compact('customer', 'title'));
    }

    public function edit(Customer $customer)
    {
        $title = "Editar Cliente";
        return view('customer.edit', compact(
            'customer',
            'title',           
        ));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = CustomerDTO::fromRequest($request);
        $updatedCustomer = $this->customerService->update($customer->id, $data);

        if ($updatedCustomer) {
            toastr()->success('Cliente actualizado correctamente');
        } else {
            toastr()->error('Error al actualizar el cliente');
        }

        return back();
    }

    public function destroy(Customer $customer)
    {
        $deleted = $this->customerService->delete($customer->id);

        if ($deleted) {
            toastr()->success('Cliente eliminado correctamente');
        } else {
            toastr()->error('Error al eliminar el cliente');
        }

        return back();
    }
}
