<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountStatusCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $title = "Estado de Cuentas Clientes";
        $compania = Company::findOrFail(Auth::user()->company_id);
        if ($search) {
            $customers = Customer::where('company_id', Auth::user()->company_id)
                ->where(function ($queryBuilder) use ($search) {
                    $queryBuilder->where('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('identification_card', $search);
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $customers = $compania->customers()
                ->orderBy('full_name', 'asc')
                ->paginate(10);
        }
        return view('accountsattuscustomer.index', compact('title', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function abonar($id)
    {
        $title = 'Nuevo Abono';
        $sale =    $customer = Sale::find($id);
        $cusntomer_id = $sale->customer_id;
        return view('salepyment.create', compact('sale', 'title', 'cusntomer_id'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $customerId)
    {

        $customer = Customer::find($customerId);
        $balance = Sale::where('customer_id', $customerId)
            ->where('payment_form', 'credit')
            ->sum('balance');
        $title = "Estado de Cuenta de:  $customer";


        $query = Sale::with(['customer:id,full_name', 'payments:id,sale_id,amount,date'])
            ->select(
                'id',
                'sale_number',
                'date_sale',
                'customer_id',
                'total',
                'balance',
                'term',
                'expiration_date'
            )
            ->where('balance', '>', 0) // solo ventas con saldo pendiente
            ->where('customer_id', $customerId);

        // Filtrar por cliente (opcional)

        $ventasConSaldo = $query->orderBy('date_sale', 'desc')->get()
            ->map(function ($venta) {
                // Determinar si está vencida
                $venta->vencida = Carbon::parse($venta->expiration_date)->isPast();

                // Calcular días de atraso si está vencida
                $venta->dias_atraso = $venta->vencida
                    ? Carbon::parse($venta->expiration_date)->diffInDays(Carbon::today())
                    : 0;

                return $venta;
            });

        // Total de abonos realizados en ventas con saldo pendiente
        $totalAbonos = SalePayment::whereHas('sale', function ($q) use ($customerId) {
            $q->where('balance', '>', 0);
            if ($customerId) {
                $q->where('customer_id', $customerId);
            }
        })
            ->sum('amount');

        $totalVencido = Sale::where('balance', '>', 0)
            ->whereDate('expiration_date', '<', Carbon::today()) // solo las que ya vencieron
            ->where('customer_id', $customerId)
            ->sum('balance'); // suma solo el sa


        return view(
            'accountsattuscustomer.show',
            compact(
                'title',
                'customer',
                'balance',
                'ventasConSaldo',
                'totalVencido',
                'totalAbonos',
            )
        );
    }
}
