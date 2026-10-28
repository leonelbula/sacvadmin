<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Jobs\ExportSalesReportJob;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Shopping;
use App\Models\ShoppingDetail;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Kardex;
use App\Models\PaymentMethod;
use App\Models\Pos;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | FILTRO GENERAL DE FECHAS
    |--------------------------------------------------------------------------
    */

    private function applyDateFilter($query, ?string $fechaDesde, ?string $fechaHasta, string $column = 'date')
    {
        return $query
            ->when(
                $fechaDesde,
                function ($query) use ($fechaDesde, $column) {
                    $query->whereDate(
                        $column,
                        '>=',
                        $fechaDesde
                    );
                }
            )
            ->when(
                $fechaHasta,
                function ($query) use ($fechaHasta, $column) {
                    $query->whereDate(
                        $column,
                        '<=',
                        $fechaHasta
                    );
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */


    public function getDashboard(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        return [

            'totalSales' => $this->getTotalSales(
                $fechaDesde,
                $fechaHasta
            ),

            'totalPurchases' => $this->getTotalPurchases(
                $fechaDesde,
                $fechaHasta
            ),

            'totalExpenses' => $this->getTotalExpenses(
                $fechaDesde,
                $fechaHasta
            ),

            'utility' => $this->getUtility(
                $fechaDesde,
                $fechaHasta
            ),

        ];
    }


    public function getTotalSales(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        $query = Sale::query();

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        return $query->sum('total');
    }


    public function getTotalPurchases(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        $query = Shopping::query();

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        return $query->sum('total');
    }


    public function getTotalExpenses(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        $query = Expense::query();

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        return $query->sum('total');
    }


    public function getUtility(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): int|float {

        $sales = $this->getTotalSales(
            $fechaDesde,
            $fechaHasta
        );

        $purchases = $this->getTotalPurchases(
            $fechaDesde,
            $fechaHasta
        );

        $expenses = $this->getTotalExpenses(
            $fechaDesde,
            $fechaHasta
        );

        return $sales - $purchases - $expenses;
    }




    public function getSalesReport(?string $fechaDesde = null, ?string $fechaHasta = null, int $perPage = 15): array
    {
        $query = Sale::with(['customer', 'user',]);

        $this->applyDateFilter($query, $fechaDesde, $fechaHasta, 'date_sale');

        $totalGeneral = (clone $query)->sum('total');

        $cantidadTotal = (clone $query)->count();

        $sales = (clone $query)
            ->orderByDesc('date_sale')
            ->paginate($perPage)
            ->withQueryString();

        return [
            'sales' => $sales,
            'total' => $totalGeneral,
            'quantity' => $cantidadTotal,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS VENDIDOS
    |--------------------------------------------------------------------------
    */

    public function getSalesProductsReport(?string $fechaDesde = null, ?string $fechaHasta = null): array
    {

        $query = SaleDetail::with([
            'product',
            'sale',
        ]);

        $query->whereHas(
            'sale',
            function ($saleQuery) use (
                $fechaDesde,
                $fechaHasta
            ) {

                $this->applyDateFilter(
                    $saleQuery,
                    $fechaDesde,
                    $fechaHasta,
                    'date_sale'
                );
            }
        );

        $products = $query
            ->get()
            ->groupBy('product_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [

                    'product' => $first->product,

                    'quantity' => $items->sum('quantity'),

                    'total' => $items->sum(
                        function ($item) {

                            return $item->subtotal
                                ?? $item->total
                                ?? 0;
                        }
                    ),

                ];
            })
            ->sortByDesc('quantity')
            ->values();

        return [

            'products' => $products,

            'total' => $products->sum('total'),

            'quantity' => $products->sum('quantity'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VENTAS POR MÉTODO DE PAGO
    |--------------------------------------------------------------------------
    |
    | NOTA:
    | En tu sistema los métodos de pago pueden estar almacenados
    | dentro de sales como JSON.
    |
    | Este método contempla esa estructura.
    |
    */

    public function getSalesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Sale::query()
            ->with('paymentMethod');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $query->get();

        $payments = [];

        foreach ($sales as $sale) {

            $paymentMethodId = $sale->payment_method_id;

            if (!$paymentMethodId) {
                continue;
            }

            if (!isset($payments[$paymentMethodId])) {

                $payments[$paymentMethodId] = [
                    'payment_method_id' => $paymentMethodId,
                    'quantity' => 0,
                    'total' => 0,
                ];
            }

            $payments[$paymentMethodId]['quantity']++;

            $payments[$paymentMethodId]['total'] +=
                (float) ($sale->total ?? 0);
        }

        $methodIds = array_keys($payments);

        if (empty($methodIds)) {
            return [
                'payments' => collect(),
                'total' => 0,
                'quantity' => 0,
            ];
        }

        $paymentMethods = PaymentMethod::whereIn(
            'id',
            $methodIds
        )
            ->get()
            ->keyBy('id');

        $payments = collect($payments)
            ->map(function ($payment) use ($paymentMethods) {

                $paymentMethod = $paymentMethods->get(
                    $payment['payment_method_id']
                );

                $payment['name'] = $paymentMethod
                    ? $paymentMethod->name
                    : 'Sin método';

                return (object) $payment;
            })
            ->values();

        return [
            'payments' => $payments,
            'total' => $payments->sum('total'),
            'quantity' => $payments->sum('quantity'),
        ];
    }


    /* ventas por categoria */


    public function getProductsByCategoryReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $categories = collect();

        $salesQuery = Sale::query()
            ->with('details.product.category');

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $salesQuery->chunkById(200, function ($sales) use (&$categories) {

            foreach ($sales as $sale) {
                foreach ($sale->details as $detail) {

                    $product = $detail->product;

                    if (!$product || !$product->category) {
                        continue;
                    }

                    $category = $product->category;

                    if (!$categories->has($category->id)) {
                        $categories->put($category->id, (object) [
                            'category_id' => $category->id,
                            'name' => $category->name,
                            'quantity' => 0,
                            'total' => 0,
                        ]);
                    }

                    $categoryData = $categories->get($category->id);

                    $categoryData->quantity += (int) $detail->quantity;

                    $categoryData->total += (float) (
                        $detail->subtotal
                        ?? ($detail->quantity * $detail->price)
                    );
                }
            }
        });

        $total = $categories->sum('total');
        $quantity = $categories->sum('quantity');

        $categories = $categories
            ->map(function ($category) use ($total) {
                $category->percentage = $total > 0
                    ? ($category->total / $total) * 100
                    : 0;

                return $category;
            })
            ->sortByDesc('total')
            ->values();

        return [
            'categories' => $categories,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }






    /*
    |--------------------------------------------------------------------------
    | VENTAS POR CLIENTE
    |--------------------------------------------------------------------------
    */

    public function getSalesCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Sale::with('customer');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $query->get();

        $customers = $sales
            ->groupBy('customer_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [

                    'customer' => $first->customer,

                    'sales' => $items->count(),

                    'total' => $items->sum('total'),

                ];
            })
            ->sortByDesc('total')
            ->values();

        return [

            'customers' => $customers,

            'total' => $customers->sum('total'),

            'quantity' => $customers->sum('sales'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function getInventoryReport(int $perPage = 50): array
    {
        $products = Product::query()
            ->select(['id', 'code', 'name', 'stock', 'stock_min',])
            ->orderBy('name')->paginate($perPage);
        $summary = Product::query()
            ->selectRaw(' COUNT(*) as quantity, SUM( CASE WHEN stock > stock_min THEN 1 ELSE 0 END ) as normal, SUM( CASE WHEN stock > 0 AND stock <= stock_min THEN 1 ELSE 0 END ) as low_stock, SUM( CASE WHEN stock <= 0 THEN 1 ELSE 0 END ) as out_of_stock ')->first();
        return [
            'products' => $products,
            'quantity' => (int) $summary->quantity,
            'normal' => (int) $summary->normal,
            'lowStock' => (int) $summary->low_stock,
            'outOfStock' => (int) $summary->out_of_stock,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALORIZACIÓN DE INVENTARIO
    |--------------------------------------------------------------------------
    */


    public function getInventoryValuationReport(): array
    {
        $valuation = Product::query()
            ->selectRaw('
            COUNT(*) as quantity,
            COALESCE(SUM(stock), 0) as stock,
            COALESCE(SUM(stock * cost), 0) as inventory_cost,
            COALESCE(SUM(stock * price), 0) as inventory_price
        ')
            ->first();

        $inventoryCost = (float) $valuation->inventory_cost;
        $inventoryPrice = (float) $valuation->inventory_price;

        return [
            'quantity' => (int) $valuation->quantity,
            'stock' => (int) $valuation->stock,
            'inventory_cost' => $inventoryCost,
            'inventory_price' => $inventoryPrice,
            'utility' => $inventoryPrice - $inventoryCost,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | STOCK BAJO
    |--------------------------------------------------------------------------
    */

    public function getLowStockReport(): array
    {
        $products = Product::query()
            ->whereColumn(
                'stock',
                '<=',
                'stock_min'
            )
            ->orderBy('stock')
            ->get();

        return [

            'products' => $products,

            'quantity' => $products->count(),

        ];
    }

    public function getLowStockReportPaginated(): array
    {
        $products = Product::query()
            ->whereColumn(
                'stock',
                '<=',
                'stock_min'
            )
            ->orderBy('stock')
            ->paginate(50);

        return [

            'products' => $products,

            'quantity' => $products->count(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | KARDEX
    |--------------------------------------------------------------------------
    */


    public function getKardexReport(
        ?int $productId = null,
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        $query = Kardex::query()
            ->with('product')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc');

        $this->applyKardexFilters(
            $query,
            $productId,
            $fechaDesde,
            $fechaHasta
        );

        $kardex = $query
            ->paginate($perPage)
            ->withQueryString();

        $summary = $this->getKardexSummary(
            $productId,
            $fechaDesde,
            $fechaHasta
        );

        $productList = Product::query()
            ->select([
                'id',
                'code',
                'name',
            ])
            ->orderBy('name')
            ->get();

        return [
            'kardex' => $kardex,
            'quantity' => $summary['quantity'],
            'income' => $summary['income'],
            'output' => $summary['output'],
            'currentStock' => $summary['currentStock'],
            'productList' => $productList,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'productId' => $productId,
        ];
    }

    public function getKardexPdfReport(
        ?int $productId = null,
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {
        $query = Kardex::query()
            ->with('product')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc');

        $this->applyKardexFilters(
            $query,
            $productId,
            $fechaDesde,
            $fechaHasta
        );

        $kardex = $query->get();

        $summary = $this->getKardexSummary(
            $productId,
            $fechaDesde,
            $fechaHasta
        );

        $product = $productId
            ? Product::select('id', 'code', 'name')->find($productId)
            : null;

        return [
            'kardex' => $kardex,
            'quantity' => $summary['quantity'],
            'income' => $summary['income'],
            'output' => $summary['output'],
            'currentStock' => $summary['currentStock'],
            'product' => $product,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }

    private function getKardexSummary(
        ?int $productId,
        ?string $fechaDesde,
        ?string $fechaHasta
    ): array {
        $query = Kardex::query();

        $this->applyKardexFilters(
            $query,
            $productId,
            $fechaDesde,
            $fechaHasta
        );

        $summary = $query
            ->selectRaw('
            COUNT(*) as quantity,
            COALESCE(SUM(income), 0) as income,
            COALESCE(SUM(output), 0) as output
        ')
            ->first();

        $currentStock = $productId
            ? Product::whereKey($productId)->value('stock')
            : Product::sum('stock');

        return [
            'quantity' => (int) $summary->quantity,
            'income' => (int) $summary->income,
            'output' => (int) $summary->output,
            'currentStock' => (int) ($currentStock ?? 0),
        ];
    }

    private function applyKardexFilters(
        $query,
        ?int $productId,
        ?string $fechaDesde,
        ?string $fechaHasta
    ): void {
        if ($productId) {
            $query->where('product_id', $productId);
        }

        if ($fechaDesde) {
            $query->whereDate('date', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('date', '<=', $fechaHasta);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | COMPRAS
    |--------------------------------------------------------------------------
    */

    public function getPurchasesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Shopping::with([
            'supplier',
            'user',
        ]);

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'shopping_date'
        );

        $purchases = $query
            ->orderByDesc('shopping_date')
            ->paginate(50);

        return [
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'purchases' => $purchases,
            'subtotal' => $purchases->sum('subtotal'),
            'iva' => $purchases->sum('iva'),
            'total' => $purchases->sum('total'),
            'balance' => $purchases->sum('balance'),
            'quantity' => $purchases->count(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS COMPRADOS
    |--------------------------------------------------------------------------
    */



    public function getPurchasesProductsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        $query = ShoppingDetail::with([
            'product',
            'shopping',
        ]);

        $query->whereHas(
            'shopping',
            function ($shoppingQuery) use (
                $fechaDesde,
                $fechaHasta
            ) {
                $this->applyDateFilter(
                    $shoppingQuery,
                    $fechaDesde,
                    $fechaHasta,
                    'shopping_date'
                );
            }
        );

        $products = $query
            ->get()
            ->groupBy('product_id')
            ->map(function ($items) {

                $first = $items->first();

                $units = $items->sum('quantity');

                $totalCost = $items->sum('subtotal');

                $unitCost = $units > 0
                    ? $totalCost / $units
                    : 0;

                return (object) [
                    'product' => $first->product,
                    'units' => $units,
                    'unit_cost' => $unitCost,
                    'total_cost' => $totalCost,
                ];
            })
            ->sortByDesc('units')
            ->values();

        $quantity = $products->count();

        $units = $products->sum('units');

        $totalCost = $products->sum('total_cost');

        $averageCost = $units > 0
            ? $totalCost / $units
            : 0;

        if ($perPage > 0) {

            $currentPage = request()->integer('page', 1);

            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                $products->forPage($currentPage, $perPage)->values(),
                $products->count(),
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }

        return [
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'products' => $products,
            'quantity' => $quantity,
            'units' => $units,
            'totalCost' => $totalCost,
            'averageCost' => $averageCost,
        ];
    }



    /*
    |--------------------------------------------------------------------------
    | COMPRAS POR PROVEEDOR
    |--------------------------------------------------------------------------
    */


    public function getPurchasesSuppliersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        $query = Shopping::with('supplier');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'shopping_date'
        );

        $purchases = $query->get();

        $suppliers = $purchases
            ->groupBy('supplier_id')
            ->map(function ($items) {

                $first = $items->first();
                $supplier = $first->supplier;

                return (object) [
                    'id' => $supplier?->id,
                    'full_name' => $supplier?->full_name ?? 'Sin proveedor',
                    'identification' => $supplier?->identification ?? 'N/A',
                    'quantity' => $items->count(),
                    'subtotal' => $items->sum('subtotal'),
                    'iva' => $items->sum('iva'),
                    'total' => $items->sum('total'),
                    'balance' => $items->sum('balance'),
                ];
            })
            ->sortByDesc('total')
            ->values();

        $quantity = $suppliers->count();

        $purchasesQuantity = $suppliers->sum('quantity');

        $subtotal = $suppliers->sum('subtotal');

        $iva = $suppliers->sum('iva');

        $total = $suppliers->sum('total');

        $balance = $suppliers->sum('balance');

        if ($perPage > 0) {

            $currentPage = request()->integer('page', 1);

            $suppliers = new \Illuminate\Pagination\LengthAwarePaginator(
                $suppliers->forPage($currentPage, $perPage)->values(),
                $suppliers->count(),
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }

        return [
            'suppliers' => $suppliers,
            'quantity' => $quantity,
            'purchasesQuantity' => $purchasesQuantity,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
            'balance' => $balance,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */


    public function getExpensesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        $query = Expense::with([
            'paymentMethod',
            'typeExpense',
            'user',
        ]);

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'date'
        );

        $expenses = $query
            ->orderByDesc('date')
            ->orderByDesc('hour')
            ->get();

        $quantity = $expenses->count();
        $total = $expenses->sum('total');

        if ($perPage > 0) {
            $currentPage = request()->integer('page', 1);

            $expenses = new \Illuminate\Pagination\LengthAwarePaginator(
                $expenses->forPage($currentPage, $perPage)->values(),
                $quantity,
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }

        return [
            'expenses' => $expenses,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }



    /*
    |--------------------------------------------------------------------------
    | GASTOS POR TIPO
    |--------------------------------------------------------------------------
    */


    public function getExpensesTypesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {
        $query = Expense::with('typeExpense');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'date'
        );

        $expenses = $query->get();

        $types = $expenses
            ->groupBy('type_expense_id')
            ->map(function ($items) {

                $first = $items->first();
                $typeExpense = $first->typeExpense;

                return (object) [
                    'id' => $typeExpense?->id,
                    'description' => $typeExpense?->description ?? 'Sin tipo',
                    'quantity' => $items->count(),
                    'total' => $items->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values();

        $quantity = $types->sum('quantity');
        $total = $types->sum('total');

        if ($perPage > 0) {
            $currentPage = request()->integer('page', 1);

            $types = new \Illuminate\Pagination\LengthAwarePaginator(
                $types->forPage($currentPage, $perPage)->values(),
                $types->count(),
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }

        return [
            'types' => $types,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | GASTOS POR MÉTODO DE PAGO
    |--------------------------------------------------------------------------
    */



    public function getExpensesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null,
        int $perPage = 50
    ): array {

        $query = Expense::with('paymentMethod');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta,
            'date'
        );

        $expenses = $query
            ->orderByDesc('date')
            ->orderByDesc('hour')
            ->get();

        $paymentMethods = $expenses
            ->groupBy('payment_method_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [
                    'id' => $first->paymentMethod?->id,
                    'name' => $first->paymentMethod?->name ?? 'Sin método de pago',
                    'paymentMethod' => $first->paymentMethod,
                    'quantity' => $items->count(),
                    'total' => $items->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values();

        $quantity = $paymentMethods->sum('quantity');

        $total = $paymentMethods->sum('total');

        if ($perPage > 0) {

            $currentPage = request()->integer('page', 1);

            $paymentMethods = new \Illuminate\Pagination\LengthAwarePaginator(
                $paymentMethods
                    ->forPage($currentPage, $perPage)
                    ->values(),

                $paymentMethods->count(),

                $perPage,

                $currentPage,

                [
                    'path' => request()->url(),
                    'query' => request()->query(),
                ]
            );
        }

        return [
            'paymentMethods' => $paymentMethods,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }





    /*
    |--------------------------------------------------------------------------
    | UTILIDAD
    |--------------------------------------------------------------------------
    */




    public function getProfitReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $salesQuery = Sale::query();

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $expensesQuery = Expense::query();

        $this->applyDateFilter(
            $expensesQuery,
            $fechaDesde,
            $fechaHasta,
            'date'
        );

        $posQuery = Pos::query();

        $this->applyDateFilter(
            $posQuery,
            $fechaDesde,
            $fechaHasta,
            'closing_date'
        );

        $salesTotal = $salesQuery->sum('total');

        $grossProfit = $salesQuery->sum('utility');

        $expensesTotal = $expensesQuery->sum('total');

        $netProfit = $grossProfit - $expensesTotal;

        $costTotal = $salesTotal - $grossProfit;

        $totalCash = (clone $posQuery)
            ->sum('cash');

        $totalConsignment = (clone $posQuery)
            ->sum('consignment');

        $totalReturnsSale = (clone $posQuery)
            ->sum('returns_sale');

        $totalDelivered = (clone $posQuery)
            ->sum('delivered_value');

        $surplus = (clone $posQuery)
            ->where('difference', '>', 0)
            ->sum('difference');

        $shortage = (clone $posQuery)
            ->where('difference', '<', 0)
            ->sum('difference');

        $shortage = abs($shortage);

        $netCashDifference = $surplus - $shortage;

        $adjustedProfit = $netProfit + $netCashDifference;

        $profitMargin = $salesTotal > 0
            ? ($adjustedProfit / $salesTotal) * 100
            : 0;

        return [
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,

            'salesTotal' => $salesTotal,
            'costTotal' => $costTotal,
            'grossProfit' => $grossProfit,
            'expensesTotal' => $expensesTotal,
            'netProfit' => $netProfit,

            'totalCash' => $totalCash,
            'totalConsignment' => $totalConsignment,
            'totalReturnsSale' => $totalReturnsSale,
            'totalDelivered' => $totalDelivered,

            'surplus' => $surplus,
            'shortage' => $shortage,
            'netCashDifference' => $netCashDifference,

            'adjustedProfit' => $adjustedProfit,
            'profitMargin' => $profitMargin,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FLUJO DE CAJA
    |--------------------------------------------------------------------------
    */


    public function getCashFlowReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $salesQuery = Sale::query();

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $expensesQuery = Expense::query();

        $this->applyDateFilter(
            $expensesQuery,
            $fechaDesde,
            $fechaHasta,
            'date'
        );

        $purchasesQuery = Shopping::query();

        $this->applyDateFilter(
            $purchasesQuery,
            $fechaDesde,
            $fechaHasta,
            'shopping_date'
        );

        $posQuery = Pos::query();

        $this->applyDateFilter(
            $posQuery,
            $fechaDesde,
            $fechaHasta,
            'closing_date'
        );

        $sales = $salesQuery->sum('total');

        $expenses = $expensesQuery->sum('total');

        $purchases = $purchasesQuery->sum('total');

        $totalCash = $posQuery->sum('cash');

        $totalConsignment = $posQuery->sum('consignment');

        $totalReturnsSale = $posQuery->sum('returns_sale');

        $totalDelivered = $posQuery->sum('delivered_value');

        $surplus = (clone $posQuery)
            ->where('difference', '>', 0)
            ->sum('difference');

        $shortage = (clone $posQuery)
            ->where('difference', '<', 0)
            ->sum('difference');

        $shortage = abs($shortage);

        $income = $sales;

        $outcome =
            $expenses
            + $purchases
            + $totalReturnsSale;

        $netCashFlow =
            $income
            - $outcome
            + $surplus
            - $shortage;

        return [

            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,

            'income' => $income,

            'salesTotal' => $sales,

            'outcome' => $outcome,

            'purchases' => $purchases,

            'expenses' => $expenses,

            'totalCash' => $totalCash,

            'totalConsignment' => $totalConsignment,

            'totalReturnsSale' => $totalReturnsSale,

            'totalDelivered' => $totalDelivered,

            'surplus' => $surplus,

            'shortage' => $shortage,

            'netCashFlow' => $netCashFlow,

            'balance' => $netCashFlow,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE PAGO
    |--------------------------------------------------------------------------
    */



    public function getPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $salesQuery = Sale::query();

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $salesQuery
            ->select([
                'id',
                'payment_method_id',
                'total',
            ])
            ->get();

        $payments = [];

        foreach ($sales as $sale) {

            $paymentMethodId = $sale->payment_method_id;

            if (!$paymentMethodId) {
                continue;
            }

            if (!isset($payments[$paymentMethodId])) {

                $payments[$paymentMethodId] = [
                    'payment_method_id' => $paymentMethodId,
                    'quantity' => 0,
                    'total' => 0,
                ];
            }

            $payments[$paymentMethodId]['quantity']++;

            $payments[$paymentMethodId]['total']
                += (float) $sale->total;
        }

        $methods = PaymentMethod::query()
            ->whereIn(
                'id',
                array_keys($payments)
            )
            ->get([
                'id',
                'name',
            ])
            ->keyBy('id');

        $paymentMethods = collect($payments)
            ->map(function (array $payment) use ($methods) {

                $method = $methods->get(
                    $payment['payment_method_id']
                );

                return (object) [
                    'payment_method_id' =>
                    $payment['payment_method_id'],

                    'name' =>
                    $method?->name ?? 'Sin nombre',

                    'quantity' =>
                    $payment['quantity'],

                    'total' =>
                    $payment['total'],
                ];
            })
            ->sortByDesc('total')
            ->values();

        $total = $paymentMethods->sum('total');

        $quantity = $paymentMethods->sum('quantity');

        return [
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,

            'paymentMethods' => $paymentMethods,

            'total' => $total,

            'quantity' => $quantity,
        ];
    }






    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */


    public function getCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $salesQuery = Sale::query()
            ->with('customer');

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $salesQuery
            ->whereNotNull('customer_id')
            ->get([
                'id',
                'customer_id',
                'total',
            ]);

        $customers = [];

        foreach ($sales as $sale) {

            $customerId = $sale->customer_id;

            if (!isset($customers[$customerId])) {

                $customers[$customerId] = [
                    'customer_id' => $customerId,
                    'name' => $sale->customer?->full_name ?? 'Sin nombre',
                    'identification' => $sale->customer?->identification ?? 'Sin identificación',
                    'quantity' => 0,
                    'total' => 0,
                ];
            }

            $customers[$customerId]['quantity']++;

            $customers[$customerId]['total']
                += (float) $sale->total;
        }

        $clients = collect($customers)
            ->map(function (array $customer) {

                return (object) [
                    'customer_id' => $customer['customer_id'],
                    'name' => $customer['name'],
                    'identification' => $customer['identification'],
                    'quantity' => $customer['quantity'],
                    'total' => $customer['total'],
                ];
            })
            ->sortByDesc('total')
            ->values();

        $total = $clients->sum('total');

        $quantity = $clients->sum('quantity');

        return [
            'clients' => $clients,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | MEJORES CLIENTES
    |--------------------------------------------------------------------------
    */

    public function getTopCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $salesQuery = Sale::query()
            ->with('customer');

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $salesQuery
            ->whereNotNull('customer_id')
            ->get([
                'id',
                'customer_id',
                'total',
            ]);

        $customers = $sales
            ->groupBy('customer_id')
            ->map(function ($items) {

                $customer = $items->first()->customer;

                return (object) [
                    'customer_id' => $customer?->id,
                    'name' => $customer?->full_name ?? 'Sin nombre',
                    'identification' => $customer?->identification ?? 'Sin identificación',
                    'quantity' => $items->count(),
                    'total' => $items->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values()
            ->take(10);

        $total = $customers->sum('total');

        $quantity = $customers->sum('quantity');

        return [
            'clients' => $customers,
            'total' => $total,
            'quantity' => $quantity,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }




    /*
    |--------------------------------------------------------------------------
    | CLIENTES INACTIVOS
    |--------------------------------------------------------------------------
    */

    public function getInactiveCustomersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $customers = Customer::query()
            ->orderBy('full_name')
            ->get();

        $salesQuery = Sale::query()
            ->select([
                'id',
                'customer_id',
                'date_sale',
                'total',
            ])
            ->whereNotNull('customer_id');

        $this->applyDateFilter(
            $salesQuery,
            $fechaDesde,
            $fechaHasta,
            'date_sale'
        );

        $sales = $salesQuery
            ->orderByDesc('date_sale')
            ->get();

        $salesByCustomer = $sales
            ->groupBy('customer_id');

        $inactiveCustomers = $customers
            ->map(function ($customer) use ($salesByCustomer) {

                $customerSales = $salesByCustomer
                    ->get($customer->id, collect());

                $lastSale = $customerSales->first();

                return (object) [
                    'customer_id' => $customer->id,
                    'name' => $customer->full_name,
                    'identification' => $customer->identification,
                    'phone' => $customer->phone,
                    'last_purchase' => $lastSale?->date_sale,
                    'days_inactive' => $lastSale
                        ? now()->startOfDay()->diffInDays(
                            \Carbon\Carbon::parse($lastSale->date_sale)->startOfDay()
                        )
                        : null,
                    'total_purchases' => $customerSales->sum('total'),
                    'quantity' => $customerSales->count(),
                ];
            })
            ->filter(function ($customer) {

                return $customer->last_purchase === null;
            })
            ->sortByDesc(function ($customer) {

                return $customer->days_inactive ?? PHP_INT_MAX;
            })
            ->values();

        return [
            'clients' => $inactiveCustomers,
            'quantity' => $inactiveCustomers->count(),
            'total' => $inactiveCustomers->sum('total_purchases'),
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ];
    }
}
