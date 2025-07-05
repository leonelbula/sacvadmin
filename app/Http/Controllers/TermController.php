<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Plazo de venta";
        $terms = Term::all();
        return view('term.index', compact('title', 'terms'));
    }
    public function create()
    {
        $title = "Nuevo Plazo";
        return view('term.create', compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'value' => 'required'
        ]);
        $term = new Term();
        $term->description = $request->description;
        $term->value = $request->value;

        $term->save();

        return redirect()->route('plazo.create');
    }
    public function edit(Term $term)
    {
        $title = "editar Plazo";
        return view('term.edit', compact('title', 'term'));
    }
    public function update(Request $request, Term $term)
    {
        $request->validate([
            'description' => 'required',
            'value' => 'required'
        ]);
        $term->description = $request->description;
        $term->value = $request->value;
        $term->save();
        return redirect()->route('plazo.index');
    }

    public function destroy(Term $term)
    {
        $term->delete();
        return redirect()->route('plazo.index');
    }
}
