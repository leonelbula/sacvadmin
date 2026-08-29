<?php

namespace App\Http\Controllers;

use App\DTOs\PosDTO;
use App\Models\Company;
use App\Models\Pos;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\spent;
use App\Services\PosService;
use App\Services\SaleService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

date_default_timezone_set('America/Bogota'); // ✅ OK para Colombia

class PosController extends Controller
{

    public function __construct(
        protected PosService $pos_service,
        protected SaleService $sale_service
    ) {}
    public function index(): View
    {
        $title = 'Pos';
        $closures = [];

        return view('pos.index', compact('title', 'closures'));
    }
    public function create()
    {
        $title = 'Iniciar Pos';

        $posActive = $this->pos_service->posActive(Auth::user()->id);

        if ($posActive) {
            return  redirect()->route('pos.previewclose');
        }

        return view('pos.start-pos', compact('title'));
    }
    public function show($id)
    {

        $title = 'Cierre de caja';
        $pos =  $this->pos_service->findById($id);
        return view('pos.show', compact('title', 'pos'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'box_base'   => 'required|numeric|min:0',
        ]);



        $userId = Auth::id();
        $posActive = $this->pos_service->posActive($userId);

        if ($posActive) {
            toastr()->error('El usuario ya tiene un punto de venta activo.');
            return back();
        }

        try {
            $dto = PosDTO::fromRequest($request);
            $this->pos_service->create($dto);

            toastr()->success('Punto de venta iniciado correctamente.');
            return redirect()->route('sale.create');
        } catch (\Exception $e) {
            // 3. Loguear el error para depuración y mostrar mensaje seguro al usuario
            Log::error('Error al iniciar punto de venta: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id'   => $userId
            ]);

            toastr()->error('No se pudo iniciar el punto de venta. Intente nuevamente.' . $e->getMessage());
            //dd($e->getMessage());
            return back();
        }
    }
    public function previewclose()
    {
        $title = "Cierre de Pos";
        $box = $this->pos_service->posActive(Auth::id());
        $sales = $this->sale_service->getSalesByBox($box);

        return view('pos.preview', [
            'box' => $box,
            'sales' => $sales['sales'],
            'quantity' => $sales['quantity'],
            'totalSales' => $sales['total_sales'],
        ]);
    }
    public function previewcloseConfirmar(Request $request)
    {
        $userId = Auth::user()->id;
        $title = "Detalles Cierre";
        $posActive = Pos::where('user_id', Auth::user()->id)
            ->where('state', 1)
            ->first();

        $venta = Sale::where('user_id', $userId)
            ->latest()
            ->first();




        $fechaInicio = $posActive->start_date;
        $fechaFin = $request->date;
        $horaInicio = $posActive->start_time;

        $horaFin = $venta
            ? $venta->created_at->format('H:i:s')
            :  Carbon::now()->format('H:i:s');

        //$horaFin = Carbon::now()->format('H:i:s');



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
        //$diferencia = $valueTotal - $totalVentas;
        $pos = $posActive;
        // return view('pos.preview', compact('title', 'pos', 'date', 'totalVentas', 'totalVentasEfectivo', 'totalVentasConsignacion', 'returnsale', 'spents', 'amount', 'diferencia', 'abono_sale'));
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
