<?php

namespace App\Http\Controllers;

use App\DTOs\PosDTO;
use App\Models\Pos;
use App\Models\ReturnSale;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\spent;
use App\Models\User;
use App\Services\ExpenseService;
use App\Services\PosService;
use App\Services\SaleReturnService;
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
        protected SaleService $sale_service,
        protected ExpenseService $expense_Service,
        protected SaleReturnService $sale_return
    ) {}
    public function index(Request $request): View
    {
        $userAll = User::all();
        if (!empty($request->all())) {
            $closures = $this->pos_service->search($request->all());
        } else {
            $closures = $this->pos_service->All();
        }

        return view('pos.index', compact('closures','userAll'));
    }
    public function create()
    {
        $posActive = $this->pos_service->posActive(Auth::user()->id);

        if ($posActive->state == 0) {
            return  redirect()->route('pos.previewclose');
        }

        return view('pos.start-pos');
    }
    public function show(int $id)
    {
        $box =  $this->pos_service->findById($id);
        return view('pos.show', compact('box'));
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
        $box = $this->pos_service->posActive(Auth::id());
        $sales = $this->sale_service->getSalesByBox($box);
        $totalExpenses = $this->expense_Service->getTotalExpensesForClosing($box);
        $returnSale = $this->sale_return->getSalesReturnByBox($box);



        return view('pos.preview', [
            'box' => $box,
            'sales' => $sales['sales'],
            'quantity' => $sales['quantity'],
            'totalSales' => $sales['total_sales'],
            'totalExpenses' => $totalExpenses,
            'returnSale' => $returnSale
        ]);
    }

    public function update(Request $request, int $id)
    {
        $box = $this->pos_service->posActive(Auth::id());

        if ($box->id == $id) {
            $boxClose =  $this->pos_service->update($id, $request->all());
            toastr()->success('Caja Cerrada Corectamente');
            return  redirect()->route('pos.show', $boxClose->id);
        } else {
            toastr()->error('Post no coresponde al iniciado');
            return back();
        }
    }
}
