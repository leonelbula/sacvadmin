<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use App\Services\ReportPdfService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService,
        protected ReportPdfService $reportPdfService
    ) {}

    private function dates(): array
    {
        return request()->validate([
            'fecha_desde' => ['nullable', 'date'],
            'fecha_hasta' => ['nullable', 'date', 'after_or_equal:fecha_desde'],
        ]);
    }

    /**
     * Panel principal de reportes.
     */

    public function index()
    {
        $filters = $this->dates();

        $data = $this->reportService->getDashboard(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );

        return view('reports.index', [

            ...$data,

            'fechaDesde' =>
            $filters['fecha_desde'] ?? null,

            'fechaHasta' =>
            $filters['fecha_hasta'] ?? null,

        ]);
    }

    public function kardex(Request $request)
    {
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $data = $this->reportService->getKardexReport($fechaDesde, $fechaHasta);
        return view('reports.kardex', [
            'kardex' => $data['kardex'],
            'quantity' => $data['quantity'],
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ]);
    }


    /**
     * Reporte de ventas.
     */
    public function sales(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Productos vendidos.
     */
    public function salesProducts(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesProductsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales-products', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Ventas por método de pago.
     */
    public function salesPaymentMethods(): View
    {

        $filters = $this->dates();

        $data = $this->reportService->getSalesPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view(
            'reports.sale.sales-payment-methods',

            [
                ...$data,
                'fechaDesde' => $filters['fecha_desde'] ?? null,
                'fechaHasta' => $filters['fecha_hasta'] ?? null,
            ]
        );
    }


    /**
     * Ventas por cliente.
     */
    public function salesCustomers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getSalesCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.sales-customers', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


public function getProductsByCategory(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getProductsByCategoryReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.sale.products-by-category', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }






    /**
     * Reporte de inventario.
     */
    public function inventory(): View
    {

        $data = $this->reportService->getInventoryReport();

        return view('reports.inventory.inventory', $data);
    }


    /**
     * Valorización del inventario.
     */
    public function inventoryValuation(): View
    {
        $data = $this->reportService->getInventoryValuationReport();

        return view('reports.inventory.inventory-valuation', $data);
    }


    /**
     * Productos con stock bajo.
     */
    public function inventoryLowStock(): View
    {
        $data = $this->reportService->getLowStockReportPaginated();

        return view('reports.inventory.inventory-low-stock', $data);
    }


    /**
     * Kardex.
     */
    public function inventoryKardex(): View
    {
        $filters = $this->dates();
        $product_id = request()->input('product_id');
        $data = $this->reportService->getKardexReport($product_id ?? null, $filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.inventory.kardex', $data);
    }


    /**
     * Reporte de compras.
     */
    public function purchases(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases', $data);
    }


    /**
     * Productos comprados.
     */
    public function purchasesProducts(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesProductsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases-products', $data);
    }


    /**
     * Compras por proveedor.
     */
    public function purchasesSuppliers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPurchasesSuppliersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.shopping.purchases-suppliers', $data);
    }


    /**
     * Reporte de gastos.
     */
    public function expenses()
    {
        $filters = $this->dates();
        $data = $this->reportService->getExpensesReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);
        return view('reports.expenses.expenses', [
            ...$data,
            'fechaDesde' => $filters['fecha_desde'] ?? null,
            'fechaHasta' => $filters['fecha_hasta'] ?? null,
        ]);
    }


    /**
     * Gastos por tipo.
     */
    public function expensesTypes(): View
    {

        $filters = $this->dates();
        $data = $this->reportService->getExpensesTypesReport(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );

        return view('reports.expenses.expenses-types', $data);
    }


    /**
     * Gastos por método de pago.
     */
    public function expensesPaymentMethods(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getExpensesPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.expenses.expenses-payment-methods', $data);
    }


    /**
     * Reporte de utilidad.
     */
    public function profit(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getProfitReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.profit', $data);
    }


    /**
     * Flujo de caja.
     */
    public function cashFlow(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getCashFlowReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.cash-flow', $data);
    }


    /**
     * Reporte general de métodos de pago.
     */
    public function paymentMethods(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getPaymentMethodsReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.financial.payment-methods', $data);
    }


    /**
     * Reporte de clientes.
     */
    public function customers(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers', $data);
    }


    /**
     * Mejores clientes.
     */
    public function customersTop(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getTopCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers-top', $data);
    }


    /**
     * Clientes inactivos.
     */
    public function customersInactive(): View
    {
        $filters = $this->dates();
        $data = $this->reportService->getInactiveCustomersReport($filters['fecha_desde'] ?? null, $filters['fecha_hasta'] ?? null);

        return view('reports.customers.customers-inactive', $data);
    }


    /*
|--------------------------------------------------------------------------
| PDF - VENTAS
|--------------------------------------------------------------------------
*/

    public function salesPdf(Request $request): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->sales(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }




    public function salesProductsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->salesProducts(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function salesPaymentMethodsPdf(): Response
    {
         $filters = $this->dates();
        return $this->reportPdfService->salesPaymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function salesCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->salesCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function getProductsByCategoryPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->getProductsByCategory(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - INVENTARIO
|--------------------------------------------------------------------------
*/

    public function inventoryPdf(): Response
    {
        return $this->reportPdfService->inventory();
    }

    public function inventoryValuationPdf(): Response
    {
        return $this->reportPdfService->inventoryValuation();
    }

    public function inventoryLowStockPdf(): Response
    {
        return $this->reportPdfService->inventoryLowStock();
    }

    public function kardexPdf(): Response
    {
        $filters = $this->dates();
        $product_id = request()->input('product_id');
        return $this->reportPdfService->kardex(
            $product_id ?? null,
             $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - COMPRAS
|--------------------------------------------------------------------------
*/

    public function purchasesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchases(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function purchasesProductsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchasesProducts(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function purchasesSuppliersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->purchasesSuppliers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - GASTOS
|--------------------------------------------------------------------------
*/

    public function expensesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expenses(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function expensesTypesPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expensesTypes(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function expensesPaymentMethodsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->expensesPaymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - FINANCIERO
|--------------------------------------------------------------------------
*/

    public function profitPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->profit(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function cashFlowPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->cashFlow(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function paymentMethodsPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->paymentMethods(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }


    /*
|--------------------------------------------------------------------------
| PDF - CLIENTES
|--------------------------------------------------------------------------
*/

    public function customersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->customers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function topCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->topCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }

    public function inactiveCustomersPdf(): Response
    {
        $filters = $this->dates();
        return $this->reportPdfService->inactiveCustomers(
            $filters['fecha_desde'] ?? null,
            $filters['fecha_hasta'] ?? null
        );
    }
}
/*
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\Spent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reporteinventario()
    {
        $title = 'REporte de Inventario';
        $totalInventario = Product::selectRaw('SUM(amount * cost) as total_inventario')
            ->value('total_inventario');

        return view('reports.product.index', compact('title', 'totalInventario'));
    }

    public function productsTopSelling(Request $request)
    {
        // Consultar productos más vendidos
        $productos = Product::select(
            'products.id',
            'products.name',
            'products.price',
            DB::raw('SUM(sale_details.quantity) as total_vendido')
        )
            ->join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_vendido')
            ->get();

        // Generar el PDF con la vista
        $pdf = Pdf::loadView('reports.products_top_selling', compact('productos'))
            ->setPaper('a4', 'portrait');

        // ver
        return $pdf->stream('reporte_productos_mas_vendidos.pdf');
        // Descargar PDF
        // return $pdf->download('reporte_productos_mas_vendidos.pdf');
    }
    public function productsTopSellingByDate(Request $request)
    {
        // Fechas seleccionadas (por defecto, hoy)
        $fechaInicio = $request->input('fecha_inicio', now()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        // Consulta con filtro de rango de fechas
        $productos = Product::select(
            'products.id',
            'products.name',
            'products.price',
            DB::raw('SUM(sale_details.quantity) as total_vendido'),
            DB::raw('DATE(sales.date_sale) as fecha')
        )
            ->join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->whereBetween(DB::raw('DATE(sales.date_sale)'), [$fechaInicio, $fechaFin])
            ->groupBy('products.id', 'products.name', 'products.price', 'fecha')
            ->orderBy('fecha')
            ->orderByDesc('total_vendido')
            ->get();

        // Generar PDF
        $pdf = Pdf::loadView('reports.products_top_selling_by_date', compact('productos', 'fechaInicio', 'fechaFin'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream("reporte_productos_vendidos_{$fechaInicio}_a_{$fechaFin}.pdf");

        //return $pdf->download("reporte_productos_vendidos_{$fechaInicio}_a_{$fechaFin}.pdf");
    }
    //productos menos vendidos
    public function productsLessSellingByDate(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        $productos = Product::select(
            'products.id',
            'products.name',
            'products.price',
            DB::raw('SUM(sale_details.quantity) as total_vendido'),
            DB::raw('DATE(sales.date_sale) as fecha')
        )
            ->join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->whereBetween(DB::raw('DATE(sales.date_sale)'), [$fechaInicio, $fechaFin])
            ->groupBy('products.id', 'products.name', 'products.price', 'fecha')
            ->orderBy('fecha')
            ->orderBy('total_vendido', 'asc') // 👈 menos vendidos
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'reports.products_less_selling_by_date',
            compact('productos', 'fechaInicio', 'fechaFin')
        )->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_productos_menos_vendidos_{$fechaInicio}_a_{$fechaFin}.pdf");
    }
    public function productReportByCode(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());
        $codigo = $request->input('codigo');

        // Buscar producto por código
        $producto = Product::where('code', $codigo)->first();

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado con el código ingresado.');
        }

        // Consultar ventas de ese producto en el rango de fechas
        $ventas = DB::table('sale_details')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->select(
                DB::raw('DATE(sales.date_sale) as fecha'),
                DB::raw('SUM(sale_details.quantity) as cantidad_vendida'),
                DB::raw('SUM(sale_details.quantity * sale_details.price) as total_generado')
            )
            ->where('sale_details.product_id', $producto->id)
            ->whereBetween(DB::raw('DATE(sales.date_sale)'), [$fechaInicio, $fechaFin])
            ->groupBy('fecha')
            ->orderBy('fecha', 'asc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'reports.product_report_by_code',
            compact('producto', 'ventas', 'fechaInicio', 'fechaFin')
        )->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_producto_{$producto->code}_{$fechaInicio}_a_{$fechaFin}.pdf");
    }

    public function productosmasvendidos()
    {
        $productosMasVendidos = Product::select('products.id', 'products.name')
            ->join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->selectRaw('SUM(sale_details.quantity) as total_vendido')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_vendido')
            ->get();
        $productosMasVendidosValor = Product::select('products.id', 'products.name')
            ->join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->selectRaw('SUM(sale_details.quantity) as total_vendido')
            ->selectRaw('SUM(sale_details.quantity * products.price) as valor_total')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_vendido') // ordena por cantidad vendida
            ->take(10) // opcional: los 10 más vendidos
            ->get();
    }
    public function reportsale()
    {
        $title = "Reporte de Ventas";
        $totalVentas = Sale::sum('total');
        $totalUtilidad = Sale::sum('utility');
        $totalDevoluciones = ReturnSale::sum('total');
        $totalGastos = spent::sum('total');
        return view(
            'reports.report_sale_index',
            compact(
                'title',
                'totalVentas',
                'totalUtilidad',
                'totalDevoluciones',
                'totalGastos'
            )
        );
    }
    public function salesPeriodPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // Traer ventas por periodo
        $ventas = \App\Models\Sale::whereBetween('date_sale', [$request->start_date, $request->end_date])->get();

        $total = $ventas->sum('total');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.sales_period_pdf', [
            'ventas' => $ventas,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total' => $total,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("ventas_{$request->start_date}_a_{$request->end_date}.pdf");
    }
    public function monthlySalesPDF(Request $request)
    {
        $request->validate([
            'start_month' => 'required|date',
            'end_month'   => 'required|date|after_or_equal:start_month',
        ]);

        $ventas = \App\Models\Sale::selectRaw('YEAR(date_sale) as anio, MONTH(date_sale) as mes, SUM(total) as total')
            ->whereBetween('date_sale', [$request->start_month, $request->end_month])
            ->groupBy('anio', 'mes')
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        $totalGeneral = $ventas->sum('total');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.monthly_sales_pdf', [
            'ventas' => $ventas,
            'start_month' => $request->start_month,
            'end_month' => $request->end_month,
            'totalGeneral' => $totalGeneral,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("ventas_mensuales_{$request->start_month}_a_{$request->end_month}.pdf");
    }
    public function profitLossPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // Totales
        $ventas = \App\Models\Sale::whereBetween('date_sale', [$request->start_date, $request->end_date])->sum('total');
        $devoluciones = \App\Models\ReturnSale::whereBetween('date_sale', [$request->start_date, $request->end_date])->sum('total');
        $gastos = \App\Models\Spent::whereBetween('date_spent', [$request->start_date, $request->end_date])->sum('total');

        $gananciaNeta = ($ventas - $devoluciones) - $gastos;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.profit_loss_pdf', [
            'ventas' => $ventas,
            'devoluciones' => $devoluciones,
            'gastos' => $gastos,
            'gananciaNeta' => $gananciaNeta,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("reporte_ganancias_perdidas_{$request->start_date}_a_{$request->end_date}.pdf");
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


    public function salesByUserPdf(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'payment_method' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $userId = $request->user_id;
        $metodoPago = $request->payment_method;
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;



        $ventas = Sale::with('customer')
            ->where('user_id', $userId)
            ->where('payment_method', $metodoPago)
            ->whereBetween(DB::raw("DATE(created_at)"), [$fechaInicio, $fechaFin])
            ->get();

        $total = $ventas->sum('total');

        $nombreMetodo = $metodoPago == 1 ? 'Efectivo' : 'Consignación';

        $pdf = Pdf::loadView('reports.sales_by_user_pdf', [
            'ventas' => $ventas,
            'total' => $total,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'nombreMetodo' => $nombreMetodo,
        ]);

        return $pdf->stream('reporte_ventas_usuario.pdf');
    }
}

*/
