<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\Spent;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function reporteinventario()
    {
        $title = 'REporte de Inventario';
        $totalInventario = Product::selectRaw('SUM(amount * cost) as total_inventario')
            ->value('total_inventario');

        return view('reportes.reporteinventario', compact('title', 'totalInventario'));
    }
    public function gananciasPerdidas(Request $request)
    {
        $data = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'user_id'      => 'nullable|integer'
        ]);

        // Ventas
        $ventas = Sale::whereBetween('date_sale', [$data['fecha_inicio'], $data['fecha_fin']])
            ->when($data['user_id'], fn($q) => $q->where('user_id', $data['user_id']))
            ->sum('total');

        // Devoluciones
        $devoluciones = ReturnSale::whereBetween('date_sale', [$data['fecha_inicio'], $data['fecha_fin']])
            ->when($data['user_id'], fn($q) => $q->where('user_id', $data['user_id']))
            ->sum('total');

        // Gastos
        $gastos = Spent::whereBetween('date_spent', [$data['fecha_inicio'], $data['fecha_fin']])
            ->when($data['user_id'], fn($q) => $q->where('user_id', $data['user_id']))
            ->sum('total');

        $resultado = $ventas - $devoluciones - $gastos;

        $pdf = Pdf::loadView('reports.ganancias_perdidas', [
            'ventas'       => $ventas,
            'devoluciones' => $devoluciones,
            'gastos'       => $gastos,
            'resultado'    => $resultado,
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin'    => $data['fecha_fin']
        ]);

        return $pdf->setPaper('letter')->stream('reporte_ganancias_perdidas.pdf');
    }
    public function profitLoss(Request $request)
    {
        $start = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end   = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        // ==================== VENTAS ====================
        $sales = Sale::whereBetween('date_sale', [$start, $end]);
        $totalSales     = $sales->sum('total');
        $totalSalesCost = $sales->sum('cost');
        $totalSalesUtil = $sales->sum('utility');

        // ==================== DEVOLUCIONES ====================
        $returns = ReturnSale::whereBetween('date_sale', [$start, $end]);
        $totalReturns     = $returns->sum('total');
        $totalReturnsCost = $returns->sum('cost');
        $totalReturnsUtil = $returns->sum('utility');

        // ==================== GASTOS ====================
        $spents = Spent::whereBetween('date_spent', [$start, $end]);
        $totalSpents = $spents->sum('total');

        // ==================== CÁLCULOS ====================
        $ingresosNetos   = $totalSales - $totalReturns;
        $costoNeto       = $totalSalesCost - $totalReturnsCost;
        $utilidadBruta   = $totalSalesUtil - $totalReturnsUtil;
        $utilidadOperativa = $utilidadBruta - $totalSpents;

        $data = [
            'start' => $start,
            'end'   => $end,
            'totalSales' => $totalSales,
            'totalSalesCost' => $totalSalesCost,
            'totalSalesUtil' => $totalSalesUtil,
            'totalReturns' => $totalReturns,
            'totalReturnsCost' => $totalReturnsCost,
            'totalReturnsUtil' => $totalReturnsUtil,
            'totalSpents' => $totalSpents,
            'ingresosNetos' => $ingresosNetos,
            'costoNeto' => $costoNeto,
            'utilidadBruta' => $utilidadBruta,
            'utilidadOperativa' => $utilidadOperativa,
        ];

        // Generar PDF
        $pdf = PDF::loadView('reports.profit_loss', $data);
        return $pdf->stream("reporte_ganancias_perdidas.pdf");
    }
    public function profitLossDaily(Request $request)
    {
        $start = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end   = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        $dates = Sale::select('date_sale')
            ->whereBetween('date_sale', [$start, $end])
            ->groupBy('date_sale')
            ->orderBy('date_sale', 'asc')
            ->pluck('date_sale');

        $report = [];

        // Totales acumulados
        $totalSalesAll = $totalSalesCostAll = $totalSalesUtilAll = 0;
        $totalReturnsAll = $totalReturnsCostAll = $totalReturnsUtilAll = 0;
        $totalSpentsAll = 0;

        foreach ($dates as $date) {
            // Ventas
            $sales = Sale::whereDate('date_sale', $date);
            $totalSales     = $sales->sum('total');
            $totalSalesCost = $sales->sum('cost');
            $totalSalesUtil = $sales->sum('utility');

            // Devoluciones
            $returns = ReturnSale::whereDate('date_sale', $date);
            $totalReturns     = $returns->sum('total');
            $totalReturnsCost = $returns->sum('cost');
            $totalReturnsUtil = $returns->sum('utility');

            // Gastos
            $spents = Spent::whereDate('date_spent', $date);
            $totalSpents = $spents->sum('total');

            // Cálculos
            $ingresosNetos     = $totalSales - $totalReturns;
            $costoNeto         = $totalSalesCost - $totalReturnsCost;
            $utilidadBruta     = $totalSalesUtil - $totalReturnsUtil;
            $utilidadOperativa = $utilidadBruta - $totalSpents;

            $report[] = [
                'date' => $date,
                'totalSales' => $totalSales,
                'totalSalesCost' => $totalSalesCost,
                'totalSalesUtil' => $totalSalesUtil,
                'totalReturns' => $totalReturns,
                'totalReturnsCost' => $totalReturnsCost,
                'totalReturnsUtil' => $totalReturnsUtil,
                'totalSpents' => $totalSpents,
                'ingresosNetos' => $ingresosNetos,
                'costoNeto' => $costoNeto,
                'utilidadBruta' => $utilidadBruta,
                'utilidadOperativa' => $utilidadOperativa,
            ];

            // Acumulamos
            $totalSalesAll      += $totalSales;
            $totalSalesCostAll  += $totalSalesCost;
            $totalSalesUtilAll  += $totalSalesUtil;
            $totalReturnsAll    += $totalReturns;
            $totalReturnsCostAll += $totalReturnsCost;
            $totalReturnsUtilAll += $totalReturnsUtil;
            $totalSpentsAll     += $totalSpents;
        }

        // Resumen acumulado
        $summary = [
            'totalSales' => $totalSalesAll,
            'totalSalesCost' => $totalSalesCostAll,
            'totalSalesUtil' => $totalSalesUtilAll,
            'totalReturns' => $totalReturnsAll,
            'totalReturnsCost' => $totalReturnsCostAll,
            'totalReturnsUtil' => $totalReturnsUtilAll,
            'totalSpents' => $totalSpentsAll,
            'ingresosNetos' => $totalSalesAll - $totalReturnsAll,
            'costoNeto' => $totalSalesCostAll - $totalReturnsCostAll,
            'utilidadBruta' => $totalSalesUtilAll - $totalReturnsUtilAll,
            'utilidadOperativa' => ($totalSalesUtilAll - $totalReturnsUtilAll) - $totalSpentsAll,
        ];

        $pdf = PDF::loadView('reports.profit_loss_daily', compact('report', 'summary', 'start', 'end'));
        return $pdf->stream("reporte_ganancias_perdidas_diario.pdf");
    }
}
