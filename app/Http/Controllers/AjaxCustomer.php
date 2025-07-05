<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AjaxCustomer extends Controller
{
    public function customerAll()
    {
        $customers = Customer::all();
        $listCustomer = [];
        $i = 1;
        foreach ($customers as $customer) {
            $listCustomer[] = array($i++, $customer->id, $customer->full_name, $customer->identification_card, "<button type='button' class='btn btn-primary agregarCliente recuperarBoton' idCliente='" . $customer->id . "'>Agregar</button>");
        }
        return response()->json(['data' => $listCustomer], 200);
    }
    public function customerGet(Request $request)
    {
        $customer = Customer::select('id', 'identification_card', 'full_name', 'address', 'city', 'phone')->where('id', $request->id)->get();

        return response()->json($customer);
    }
}
