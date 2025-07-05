<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->company_id != '') {
            return redirect()->route('companydata.index');
        }
        return view('home.dashboard');
    }
    public function companycreate()
    {
        return view('companicreate');
    }
    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['logo'] = 'n/n';
            $data['user_id'] = Auth::user()->id;
            Company::create($data);
            $company = Company::select('id')->where('user_id', Auth::user()->id)->first();

            $user = User::find(Auth::user()->id);
            $user->company_id = $company->id;
            $user->save();
            Auth::setUser($user->fresh());
            toastr()->success('Registro guardado');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {

            toastr()->error('Informcion de guardada');
            return back();
        }
    }
}
