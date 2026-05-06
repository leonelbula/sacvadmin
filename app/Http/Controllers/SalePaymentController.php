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
use Barryvdh\DomPDF\Facade\Pdf;


class SalePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
        $sale = Sale::find($payment->sale_id);
        return view('salepyment.show', compact('title', 'payment', 'sale'));
    }

    public function edit(string $id)
    {
        $payment = SalePayment::find($id);
        $sale = Sale::find($payment->sale_id);
        $cusntomer_id = $sale->customer_id;
        $title = 'Editar Abono';
        return view('salepyment.edit', compact('title', 'payment', 'sale', 'cusntomer_id'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);
        try {
            DB::beginTransaction();
            $this->updatePayment($id, $data, $request);
            DB::commit();
            toastr()->success('Abono actualizado correctamente');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al actualizar abono: ' . $e->getMessage());
            return back();
        }
    }
    public function updatePayment($id, $data, $request)
    {
        $payment = SalePayment::find($id);
        $sale = Sale::find($payment->sale_id);
        $balance = $sale->balance + $payment->amount;
        $amount = $request->amount;
        $newBalamce = $balance - $amount;
        if ($newBalamce < 0) {
            throw new \Exception('El Abono es mayor al saldo');
        } else {
            $sale->balance = $newBalamce;
            $sale->save();
            $payment->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment_sale = SalePayment::find($id);
        $sale = Sale::find($payment_sale->sale_id);
        $sale->balance += $payment_sale->amount;
        $sale->save();
        $payment_sale->delete();
        toastr()->success('Abono eliminado correctamente');
        return back();
    }
    public function print($id)
    {
        $payment = SalePayment::find($id);
        $sale = Sale::find($payment->sale_id);
        $customer = Customer::find($sale->customer_id);
        $company = Company::find(Auth::user()->company_id);
        $date = Carbon::parse($payment->date)->format('d-m-Y');

         $pdf = Pdf::loadView('salepyment.print', compact('payment', 'sale', 'customer', 'company', 'date'))
            ->setPaper('a4', 'portrait');

        // ver
        return $pdf->stream('reporte_productos_mas_vendidos.pdf');

    }
}
