<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class SalePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);
        $data['user_id'] = Auth::user()->id;
        $sale = Sale::find($request->sale_id);

        $balance = $sale->balance;
        $amount = $request->amount;

        $newBalamce = $balance - $amount;
        if ($newBalamce < 0) {
            toastr()->error('El Abono es mayor al saldo ');
            return back();
        } else {
            $sale->balance = $newBalamce;
            var_dump($newBalamce);
        }

        DB::beginTransaction();
        try {

            $sale->balance = $newBalamce;
            $sale->update();
            SalePayment::create($data);

            DB::commit();
            toastr()->success('Registro guardado correctamente');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar abono: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detalles Abonos';
        $payment = SalePayment::find($id);

        return view('salepyment.show', compact('title','payment'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
