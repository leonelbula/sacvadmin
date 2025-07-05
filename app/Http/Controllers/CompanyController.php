<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function index(): View
    {
        return view('companydata.index');
    }

}
