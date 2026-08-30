<?php

namespace App\Http\Controllers;

use App\Models\spent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpentController extends Controller
{

    public function index()
    {
        $spents = spent::orderBy('id', 'DESC')->get();
        $title = "Gastos";
        return view('Expence.index', compact('title', 'spents'));
    }
    public function create()
    {
        $title = "Nuevo gasto";
        return view('Expence.create', compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'total' => 'required',
            'date_spent' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $spent = new spent();
            $spent->description = $request->description;
            $spent->total = $request->total;
            $spent->hour = date('h:m:s');
            $spent->date_spent = $request->date_spent;
            $spent->user_id = Auth::user()->id;

            $spent->save();

            DB::commit();
            toastr()->success('Informacion guardada correctamente');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
    public function edit(spent $spent)
    {
        $title = "Editar gasto";
        return view('Expence.edit', compact('title', 'spent'));
    }
    public function update(Request $request, spent $spent)
    {
        $request->validate([
            'description' => 'required',
            'total' => 'required',
            'date_spent' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $spent->description = $request->description;
            $spent->total = $request->total;
            $spent->date_spent = $request->date_spent;
            $spent->save();
            DB::commit();
            toastr()->success('Informacion guardada correctamente');
            return redirect()->route('spent.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Error al guardar la informacion');
            return back();
        }
    }
    public function destroy(spent $spent)
    {
        $spent->delete();
        return redirect()->route('spent.index');
    }
}
