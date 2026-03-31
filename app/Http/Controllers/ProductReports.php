<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductReports extends Controller
{
    public function index()
    {
        return view('reports.product.index');
    }

    public function stockGeneral()
    {
        $compania = Company::findOrFail(Auth::user()->company_id);
        $products = $compania->products()
            ->select('id', 'code', 'name', 'amount', 'cost', 'price')
            ->where('amount', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(10);

        $totalCosto = $products->sum(fn($p) => $p->amount * $p->cost);
        $totalVenta = $products->sum(fn($p) => $p->amount * $p->price);
        return view('reports.product..stock', compact('products', 'totalCosto', 'totalVenta'));
    }
    public function downloadPdfStock()
    {

        $compania = Company::findOrFail(Auth::user()->company_id);
        $products = $compania->products()
            ->select('id', 'code', 'name', 'amount', 'minimum_amount', 'cost')
            ->where('amount', '>', 0)
            ->orderBy('name', 'asc')
            ->get();


        $pdf = Pdf::loadView('reports.pdf.product.stopProduct', compact('products'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('reporte_stock_productos.pdf');
    }

    public function lowStock()
    {
        $compania = Company::findOrFail(Auth::user()->company_id);
        $products = $compania->products()
            ->select('id', 'code', 'name', 'amount', 'minimum_amount', 'cost')
            ->whereColumn('amount', '<=', 'minimum_amount')
            ->orderBy('name', 'asc')
            ->paginate(10);
        //$products = Product::whereColumn('amount', '<=', 'minimum_amount')->get();
        return view('reports.product.low_stock', compact('products'));
    }
    public function downloadlowStock()
    {
        $companyId = Auth::user()->company_id;

        $products = Product::where('company_id', $companyId)
            ->whereColumn('amount', '<=', 'minimum_amount')
            ->orderBy('amount', 'asc')
            ->get();

        $pdf = Pdf::loadView(
            'reports.pdf.product.lowProduct',
            compact('products')
        )->setPaper('a4', 'portrait');

        return $pdf->stream('productos_bajo_stock.pdf');
         //return $pdf->download('productos_bajo_stock.pdf');
    }


    public function kardex()
    {
        return view('reports.product.kardex');
    }

    public function byCategory()
    {
        $products = Product::with('category')->get();
        return view('reports.product.category', compact('products'));
    }

    public function bySupplier()
    {
        $products = Product::with('supplier')->get();
        return view('reports.product.supplier', compact('products'));
    }

    public function valuation()
    {
        $products = Product::selectRaw(
            'name, stock, cost, (stock * cost) as total'
        )->get();

        return view('reports.product.valuation', compact('products'));
    }

    public function expired()
    {
        $products = Product::whereDate('expiration_date', '<', now())->get();
        return view('reports.product.expired', compact('products'));
    }

    public function history()
    {
        return view('reports.product.history');
    }
}
