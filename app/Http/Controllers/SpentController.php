<?php

namespace App\Http\Controllers;

use App\Models\spent;
use App\Models\User;
use Illuminate\Http\Request;

class SpentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $spents = spent::orderBy('id', 'DESC')->get();
        $title = "Gastos";
        return view('spent.index', compact('title', 'spents'));
    }
    public function create()
    {
        $title = "Nuevo gasto";
        return view('spent.create', compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'total' => 'required',
            'date' => 'required',
        ]);


        $spent = new spent();
        $spent->description = $request->description;
        $spent->total = $request->total;
        $spent->hour = date('h:m:s');
        $spent->date_spent = $request->date;
        $spent->user_id = auth()->user()->id;

        $spent->save();

        return redirect()->route('gasto.index');
    }
    public function edit(spent $spent)
    {
        $title = "Editar gasto";
        return view('spent.edit', compact('title', 'spent'));
    }
    public function update(Request $request, spent $spent)
    {
        $request->validate([
            'description' => 'required',
            'total' => 'required',
            'date' => 'required',
        ]);

        $spent->description = $request->description;
        $spent->total = $request->total;
        $spent->hour = date('h:m:s');
        $spent->date_spent = $request->date;
        $spent->user_id = auth()->user()->id;

        $spent->save();

        return redirect()->route('gasto.index');
    }
    public function destroy(spent $spent)
    {
        $spent->delete();
        return redirect()->route('gasto.index');
    }
}
