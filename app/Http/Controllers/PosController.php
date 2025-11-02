<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Pos;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\spent;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

date_default_timezone_set('America/Bogota'); // ✅ OK para Colombia

class PosController extends Controller
{
    public function index(): View
    {
        $title = 'Pos';
        $compania = Company::findOrFail(Auth::user()->company_id);
        $closings = $compania->pos()
            ->orderBy('start_date', 'asc')
            ->paginate(10);
        $closingpos = Pos::where('user_id', Auth::user()->id)
            ->where('state', 1)
            ->first();
        return view('pos.index', compact('title', 'closings', 'closingpos'));
    }
    public function create(): View
    {
        $title = 'Nuevo';
        return view('pos.create', compact('title',));
    }
    public function show($pos)
    {

        $title = 'Cieere de caja';
        $pos = Pos::find($pos);
       return view('pos.show',compact('title', 'pos'));
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'start_date'   => 'required|date',
            'box_base'       => 'required|numeric|min:0',
        ]);

        $registros = Pos::where('user_id', Auth::user()->id)
            ->where('state', 1)
            ->get();

        if (empty($registros)) {
            if ($registros->state == 1) {
                toastr()->error('El Usuario ya tiene Pos activo');
                return back();
            }
        }

        DB::beginTransaction();
        $data = $request->all();
        try {
            $data['total_sale'] = 0;
            $data['difference'] = 0;
            $data['start_time'] = Carbon::now()->format('H:i:s');
            $data['closing_time'] = Carbon::now()->format('H:i:s');
            $data['closing_date'] = date('Y-m-d');
            $data['bills'] = 0;
            $data['consignment'] = 0;
            $data['cash'] = 0;
            $data['returns_sale'] = 0;
            $data['state'] = 1;
            $data['delivered_value'] = 0;
            $data['user_id'] = Auth::user()->id;
            $data['company_id'] = Auth::user()->company_id;
            Pos::create($data);
            DB::commit();
            toastr()->success('Punto de Venta iniciado correctamnente');
            return redirect()->route('sale.create');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al iniciar punto de venta');
            return back();
        }
    }
    public function previewclose()
    {
        $title = "Cierre de Pos";
        return view('pos.frmclose', compact('title'));
    }
    public function previewcloseConfirmar(Request $request)
    {
        $title = "Detalles Cierre";
        $posActive = Pos::where('user_id', Auth::user()->id)
            ->where('state', 1)
            ->first();

        $userId = Auth::user()->id;
        $fechaInicio = $posActive->start_date;
        $fechaFin = $request->date;
        $horaInicio = $posActive->start_time;
        $horaFin = Carbon::now()->format('H:i:s');;

        $totalVentas = Sale::where('user_id', $userId)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->where('payment_form', 'counted')
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');

        $returnsale = ReturnSale::where('user_id', $userId)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');

        $totalVentasEfectivo = Sale::where('user_id', $userId)
            ->where('payment_method', 1)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');
        $totalVentasConsignacion = Sale::where('user_id', $userId)
            ->where('payment_method', 2)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');

        $totalVentasTargetaCredito = Sale::where('user_id', $userId)
            ->where('payment_method', 3)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');
        $spents = spent::where('user_id', $userId)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('total');

        $abono_sale = SalePayment::where('user_id', $userId)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->whereTime('created_at', '>=', $horaInicio)
            ->whereTime('created_at', '<=', $horaFin)
            ->sum('amount');

        $amount = $request->amount;
        $date = $request->date;
        $t = $totalVentasEfectivo + $totalVentasConsignacion;
        $valueTotal = $amount + $totalVentasConsignacion + $returnsale + $spents + $abono_sale;
        $diferencia = $valueTotal - $totalVentas;
        $pos = $posActive;
        return view('pos.preview', compact('title', 'pos', 'date', 'totalVentas', 'totalVentasEfectivo', 'totalVentasConsignacion', 'returnsale', 'spents', 'amount', 'diferencia','abono_sale'));
    }
    public function previewPos(Request $request)
    {
        dd($request);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'start_date'   => 'required|date',
            'amount'       => 'required|numeric|min:0',
        ]);

        $pos = Pos::where('user_id', Auth::id())
            ->where('state', 1)
            ->first();

        if (!$pos) {
            toastr()->error('No tienes un Punto de Venta abierto.');
            return back();
        }

        DB::beginTransaction();

        try {
            $data['total_sale']      = $request->total_sale;
            $data['difference']      = $request->diferencia;
            $data['closing_time']    = Carbon::now()->toTimeString();
            $data['closing_date']    = $request->start_date;
            $data['bills']           = $request->bills;
            $data['consignment']     = $request->consignment;
            $data['cash']            = $request->cash;
            $data['returns_sale']         = $request->returns_sale;
            $data['state']           = 0;
            $data['delivered_value'] = $request->amount;

            $pos->update($data);

            DB::commit();
            toastr()->success('Punto de Venta cerrado correctamente');
            return redirect()->route('pos.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al cerrar punto de venta: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function cierre(Pos $pos)
    {
        $data = [
            'box' => $pos,
            'user' => $pos->user, // relación con el cajero
        ];

        $pdf = Pdf::loadView('pdf.cierre_caja', $data)
            ->setPaper([0, 0, 226.77, 600], 'portrait');
        // 80mm de ancho, alto dinámico

        return $pdf->stream('cierre-caja-' . $pos->id . '.pdf');
    }
}
