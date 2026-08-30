<?php

namespace App\Http\Controllers;

use App\DTOs\ExpenseDTO;
use App\Http\Requests\ExpenseRequest;
use App\Models\PaymentMethod;
use App\Models\typeExpense;
use App\Services\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(
        private ExpenseService $expenseService
    ) {}

    /**
     * Listado de gastos.
     */
    public function index(Request $request): View
    {
        $expenses = $this->expenseService->search(
            search: $request->input('search'),
            typeExpenseId: $request->input('type_expense_id'),
            paymentMethodId: $request->input('payment_method_id'),
            dateFrom: $request->input('date_from'),
            dateTo: $request->input('date_to'),
            perPage: 10
        );

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Formulario para crear un gasto.
     */
    public function create(): View
    {
        $typeExpenses = typeExpense::orderBy('description')->get();

        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('expenses.create', compact(
            'typeExpenses',
            'paymentMethods'
        ));
    }

    /**
     * Guardar un nuevo gasto.
     */
    public function store(ExpenseRequest $request): RedirectResponse
    {

        $dto = ExpenseDTO::fromRequest($request);

        $this->expenseService->create($dto);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Gasto registrado correctamente.');
    }
    /**
     * Mostrar detalle del gasto.
     */
    public function show(int $id): View
    {
        $expense = $this->expenseService->findById($id);

        abort_if(!$expense, 404);

        return view('expenses.show', compact('expense'));
    }

    /**
     * Formulario para editar.
     */
    public function edit(int $id): View
    {
        $expense = $this->expenseService->findById($id);

        abort_if(!$expense, 404);

        $typeExpenses = TypeExpense::orderBy('description')->get();

        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('expenses.edit', compact(
            'expense',
            'typeExpenses',
            'paymentMethods'
        ));
    }

    /**
     * Actualizar gasto.
     */
    public function update(
        ExpenseRequest $request,
        int $id
    ): RedirectResponse {

        $data = $request->validated();

        $this->expenseService->update(
            id: $id,
            data: $data
        );

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Gasto actualizado correctamente.');
    }

    /**
     * Eliminar gasto.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->expenseService->delete($id);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Gasto eliminado correctamente.');
    }
}
