<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Parameter;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\SaleService;
use App\Services\ShoppingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected SaleService $saleService,
        protected ProductService $productService,
        protected CustomerService $customerService,
        protected ShoppingService $shopping_service,
    ) {}

    public function dashboard()
    {
        $user = Auth::user();

        if ($user->type == 'admin') {
            $sales = $this->saleService->saleDayTotal($userId = null, now()->format('Y-m-d'));
            $lisSale = $this->saleService->saleDay($userId = null, now()->format('Y-m-d'));
        } else {
            $sales = $this->saleService->saleDayTotal($userId = $user->id, now()->format('Y-m-d'));
            $lisSale = $this->saleService->saleDay($userId = $user->id, now()->format('Y-m-d'));
        }
        $countProducts = $this->productService->countProduct();
        $LowStockProduct = $this->productService->lowStockProducts();
        $countCustomers = $this->customerService->countCustomers();
        $totalShoppig = $this->shopping_service->totalShopping();

    
        return view('dashboard.index', compact(
            'sales',
            'lisSale',
            'countProducts',
            'LowStockProduct',
            'countCustomers',
            'totalShoppig'
        ));
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
            $company =  Company::create($data);



            //$company = Company::select('id')->where('user_id', Auth::user()->id)->first();
            var_dump($company->id);
            die();
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
            var_dump($e->getMessage());
            // return back();
        }
    }
}
