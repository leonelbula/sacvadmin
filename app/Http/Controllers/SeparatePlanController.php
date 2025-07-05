<?php

namespace App\Http\Controllers;

use App\Models\SeparatePlan;
use Illuminate\Http\Request;

class SeparatePlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Lista plan separe";
        $listseparateplan = SeparatePlan::orderBy('id', 'DESC')->get();
        return view('separateplan.index', compact('title', 'listseparateplan'));
    }
    public function create()
    {
        $title = "Nuevo Plan separe";
        return view('separateplan.create', compact('title'));
    }
}
