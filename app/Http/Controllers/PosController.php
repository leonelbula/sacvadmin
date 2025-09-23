<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Pos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(): View
    {
        $title = 'Pos';
        $compania = Company::findOrFail(Auth::user()->company_id);
        $closings = $compania->pos()
            ->orderBy('start_date', 'asc')
            ->paginate(10);
            $closingpos = $compania->pos()
            ->where('state', 1)
            ->first();
        return view('pos.index', compact('title', 'closings','closingpos'));
    }
    public function create(): View
    {
        $title = 'Nuevo';
        return view('pos.create', compact('title',));
    }
    public function store(Request $request){
         $data = $request->validate([
            'start_date'   => 'required|date',
            'box_base'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        $data = $request->all();
        try {
            $data['total_sale'] = 0;
            $data['difference'] = 0;
            $data['start_time'] = Carbon::now('H:i:s');
            $data['closing_time'] = Carbon::now('H:i:s');
            $data['closing_date'] = date('Y-m-d');
            $data['bills'] = 0;
            $data['returns'] = 0;
            $data['state'] = 1;
            $data['user_id'] = Auth::user()->id;
            $data['company_id'] = Auth::user()->company_id;
            Pos::create($data);
            DB::commit();
            toastr()->success('Punto de Venta iniciado correctamnente');
        } catch (\Exception $th) {
            DB::rollBack();
            toastr()->error('Error al iniciar punto de venta');
            return back();
        }

    }
}
