<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Parameter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        try {

            $data = $request->all();
            $data['logo'] = 'n/n';
            $data['user_id'] = Auth::user()->id;
            Company::create($data);



            $company = Company::select('id')->where('user_id', Auth::user()->id)->first();

            $parameter = [
                'sale_code' => 0,
                'tax_include' => 1,
                'product_code' => 1001,
                'automatic_product' => 0,
                'company_id' => $company->id,
            ];

            Parameter::create($parameter);

            $user = User::find(Auth::user()->id);
            $user->company_id = $company->id;
            $user->save();
            Auth::setUser($user->fresh());
            DB::commit();

            toastr()->success('Registro guardado');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();

            toastr()->error('Informcion no guardada');
            return back();
        }
    }
}
