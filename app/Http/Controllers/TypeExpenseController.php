<?php

namespace App\Http\Controllers;

use App\Models\typeExpense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TypeExpenseController extends Controller
{
    public function index(TypeExpense $typeExpense)
    {

        $expenseTypes = typeExpense::query()
            ->orderBy('description')
            ->paginate(10);
        
        return view('expenses.types.index', compact('expenseTypes','typeExpense'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => ['string', 'max:500']
        ]);

        try {
            DB::transaction(function () use ($data) {
                $expenseType = new TypeExpense();
                $expenseType->description = trim($data['description']);

                $expenseType->save();
            });

            toastr()->success('Informacion guardada corectamente');
            return redirect()
                ->route('expense-types.index');
        } catch (\Throwable $e) {
            Log::error('Error al guardar tipo de gasto', [
                'message' => $e->getMessage(),
            ]);

            toastr()->error('Registro no guardado');

            return back()
                ->withInput();
        }
    }

    public function update(int $id, Request $request)
    {


        $data = $request->validate([
            'description' => ['string', 'max:500']
        ]);

        try {
            DB::transaction(function () use ($id, $data) {
                $expenseType = TypeExpense::find($id);
                $expenseType->description = trim($data['description']);

                $expenseType->update();
            });

            toastr()->success('Informacion guardada corectamente');
            return redirect()
                ->route('expense-types.index');
        } catch (\Throwable $e) {
            Log::error('Error al guardar tipo de gasto', [
                'message' => $e->getMessage(),
            ]);

            toastr()->error('Registro no guardado');

            return back()
                ->withInput();
        }
    }
    public function destroy(int $id)
    {
        $expenseType = TypeExpense::find($id);
        if ($expenseType) {
            $expenseType->delete();
            toastr()->error('Registro no guardado');
            return redirect()
                ->route('expense-types.index');
        }
        toastr()->error('Registro no guardado');

        return back();
    }
}
