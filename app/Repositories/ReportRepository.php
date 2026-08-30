<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Shopping;
use App\Models\ShoppingDetail;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Kardex;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | FILTRO GENERAL DE FECHAS
    |--------------------------------------------------------------------------
    */

    private function applyDateFilter(
        $query,
        ?string $fechaDesde,
        ?string $fechaHasta,
        string $column = 'date'
    ) {
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




public function getSalesReport(
    ?string $fechaDesde = null,
    ?string $fechaHasta = null
): array {

    $query = Sale::with([
        'customer',
        'user',
    ]);

    $this->applyDateFilter(
        $query,
        $fechaDesde,
        $fechaHasta,
        'date_sale'
    );

    $sales = $query
        ->orderByDesc('date_sale')
        ->get();

    return [

        'sales' => $sales,

        'total' => $sales->sum('total'),

        'quantity' => $sales->count(),

    ];
}



    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS VENDIDOS
    |--------------------------------------------------------------------------
    */

    public function getSalesProductsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

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
                    $fechaHasta
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

        $query = Sale::query();

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $sales = $query->get();

        $payments = [];

        foreach ($sales as $sale) {

            $salePayments = $sale->payment_methods
                ?? $sale->payments
                ?? null;

            if (is_string($salePayments)) {

                $salePayments = json_decode(
                    $salePayments,
                    true
                );
            }

            if (!is_array($salePayments)) {
                continue;
            }

            foreach ($salePayments as $payment) {

                $paymentMethodId =
                    $payment['payment_method_id']
                    ?? null;

                if (!$paymentMethodId) {
                    continue;
                }

                if (!isset($payments[$paymentMethodId])) {

                    $payments[$paymentMethodId] = [

                        'payment_method_id' =>
                        $paymentMethodId,

                        'quantity' => 0,

                        'total' => 0,

                    ];
                }

                $payments[$paymentMethodId]['quantity']
                    += (int) (
                        $payment['quantity']
                        ?? 1
                    );

                $payments[$paymentMethodId]['total']
                    += (float) (
                        $payment['total']
                        ?? 0
                    );
            }
        }

        $methodIds = array_keys($payments);

        $paymentMethods = PaymentMethod::whereIn(
            'id',
            $methodIds
        )
            ->get()
            ->keyBy('id');

        $payments = collect($payments)
            ->map(function ($payment) use (
                $paymentMethods
            ) {

                $payment['name'] =
                    $paymentMethods[$payment['payment_method_id']]->name
                    ?? 'Sin método';

                return (object) $payment;
            })
            ->values();

        return [

            'payments' => $payments,

            'total' => $payments->sum('total'),

            'quantity' => $payments->sum('quantity'),

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
            $fechaHasta
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

    public function getInventoryReport(): array
    {
        $products = Product::query()
            ->orderBy('name')
            ->get();

        return [

            'products' => $products,

            'quantity' => $products->count(),

            'stock' => $products->sum('stock'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALORIZACIÓN DE INVENTARIO
    |--------------------------------------------------------------------------
    */

    public function getInventoryValuationReport(): array
    {
        $products = Product::query()
            ->orderBy('name')
            ->get();

        $products = $products->map(
            function ($product) {

                $product->inventory_cost =
                    $product->stock * $product->cost;

                $product->inventory_price =
                    $product->stock * $product->price;

                return $product;
            }
        );

        return [

            'products' => $products,

            'totalCost' =>
            $products->sum('inventory_cost'),

            'totalPrice' =>
            $products->sum('inventory_price'),

            'stock' =>
            $products->sum('stock'),

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


    /*
    |--------------------------------------------------------------------------
    | KARDEX
    |--------------------------------------------------------------------------
    */

    public function getKardexReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Kardex::with([
            'product',
            'user',
        ]);

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $kardex = $query
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        return [

            'kardex' => $kardex,

            'quantity' => $kardex->count(),

        ];
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
            $fechaHasta
        );

        $purchases = $query
            ->orderByDesc('date')
            ->get();

        return [

            'purchases' => $purchases,

            'total' => $purchases->sum('total'),

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
        ?string $fechaHasta = null
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
                    $fechaHasta
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
    | COMPRAS POR PROVEEDOR
    |--------------------------------------------------------------------------
    */

    public function getPurchasesSuppliersReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Shopping::with('supplier');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $purchases = $query->get();

        $suppliers = $purchases
            ->groupBy('supplier_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [

                    'supplier' => $first->supplier,

                    'purchases' => $items->count(),

                    'total' => $items->sum('total'),

                ];
            })
            ->sortByDesc('total')
            ->values();

        return [

            'suppliers' => $suppliers,

            'total' => $suppliers->sum('total'),

            'quantity' =>
            $suppliers->sum('purchases'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS
    |--------------------------------------------------------------------------
    */

    public function getExpensesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Expense::with([
            'paymentMethod',
            'typeExpense',
            'user',
        ]);

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $expenses = $query
            ->orderByDesc('date')
            ->orderByDesc('hour')
            ->get();

        return [

            'expenses' => $expenses,

            'total' => $expenses->sum('total'),

            'quantity' => $expenses->count(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS POR TIPO
    |--------------------------------------------------------------------------
    */

    public function getExpensesTypesReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Expense::with('typeExpense');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $expenses = $query->get();

        $types = $expenses
            ->groupBy('type_expense_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [

                    'typeExpense' =>
                    $first->typeExpense,

                    'quantity' =>
                    $items->count(),

                    'total' =>
                    $items->sum('total'),

                ];
            })
            ->sortByDesc('total')
            ->values();

        return [

            'types' => $types,

            'total' => $types->sum('total'),

            'quantity' =>
            $types->sum('quantity'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GASTOS POR MÉTODO DE PAGO
    |--------------------------------------------------------------------------
    */

    public function getExpensesPaymentMethodsReport(
        ?string $fechaDesde = null,
        ?string $fechaHasta = null
    ): array {

        $query = Expense::with('paymentMethod');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $expenses = $query->get();

        $payments = $expenses
            ->groupBy('payment_method_id')
            ->map(function ($items) {

                $first = $items->first();

                return (object) [

                    'paymentMethod' =>
                    $first->paymentMethod,

                    'quantity' =>
                    $items->count(),

                    'total' =>
                    $items->sum('total'),

                ];
            })
            ->sortByDesc('total')
            ->values();

        return [

            'payments' => $payments,

            'total' => $payments->sum('total'),

            'quantity' =>
            $payments->sum('quantity'),

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
            $fechaHasta
        );

        $purchasesQuery = Shopping::query();

        $this->applyDateFilter(
            $purchasesQuery,
            $fechaDesde,
            $fechaHasta
        );

        $expensesQuery = Expense::query();

        $this->applyDateFilter(
            $expensesQuery,
            $fechaDesde,
            $fechaHasta
        );

        $sales = $salesQuery->sum('total');

        $purchases = $purchasesQuery->sum('total');

        $expenses = $expensesQuery->sum('total');

        $profit =
            $sales
            - $purchases
            - $expenses;

        return [

            'sales' => $sales,

            'purchases' => $purchases,

            'expenses' => $expenses,

            'profit' => $profit,

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
            $fechaHasta
        );

        $expensesQuery = Expense::query();

        $this->applyDateFilter(
            $expensesQuery,
            $fechaDesde,
            $fechaHasta
        );

        $purchasesQuery = Shopping::query();

        $this->applyDateFilter(
            $purchasesQuery,
            $fechaDesde,
            $fechaHasta
        );

        $sales = $salesQuery->sum('total');

        $expenses = $expensesQuery->sum('total');

        $purchases = $purchasesQuery->sum('total');

        $income = $sales;

        $outcome =
            $expenses
            + $purchases;

        return [

            'income' => $income,

            'sales' => $sales,

            'outcome' => $outcome,

            'purchases' => $purchases,

            'expenses' => $expenses,

            'balance' =>
            $income - $outcome,

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

        $query = Sale::query();

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
        );

        $sales = $query->get();

        /*
        |--------------------------------------------------------------------------
        | Aquí utilizamos el JSON de métodos de pago de las ventas.
        |--------------------------------------------------------------------------
        */

        $payments = [];

        foreach ($sales as $sale) {

            $salePayments = $sale->payment_methods
                ?? $sale->payments
                ?? null;

            if (is_string($salePayments)) {

                $salePayments = json_decode(
                    $salePayments,
                    true
                );
            }

            if (!is_array($salePayments)) {
                continue;
            }

            foreach ($salePayments as $payment) {

                $id =
                    $payment['payment_method_id']
                    ?? null;

                if (!$id) {
                    continue;
                }

                if (!isset($payments[$id])) {

                    $payments[$id] = [

                        'payment_method_id' => $id,

                        'quantity' => 0,

                        'total' => 0,

                    ];
                }

                $payments[$id]['quantity']
                    += (int) (
                        $payment['quantity']
                        ?? 1
                    );

                $payments[$id]['total']
                    += (float) (
                        $payment['total']
                        ?? 0
                    );
            }
        }

        $methods = PaymentMethod::whereIn(
            'id',
            array_keys($payments)
        )
            ->get()
            ->keyBy('id');

        $payments = collect($payments)
            ->map(function ($item) use ($methods) {

                $item['paymentMethod'] =
                    $methods[$item['payment_method_id']] ?? null;

                return (object) $item;
            })
            ->values();

        return [

            'payments' => $payments,

            'total' => $payments->sum('total'),

            'quantity' =>
            $payments->sum('quantity'),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENTES
    |--------------------------------------------------------------------------
    */

    public function getCustomersReport(): array
    {
        $customers = Customer::query()
            ->with('city')
            ->orderBy('full_name')
            ->get();

        return [

            'customers' => $customers,

            'quantity' => $customers->count(),

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

        $query = Sale::with('customer');

        $this->applyDateFilter(
            $query,
            $fechaDesde,
            $fechaHasta
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
            ->values()
            ->take(10);

        return [

            'customers' => $customers,

            'total' => $customers->sum('total'),

            'quantity' => $customers->count(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CLIENTES INACTIVOS
    |--------------------------------------------------------------------------
    */

    public function getInactiveCustomersReport(): array
    {
        $customers = Customer::query()
            ->whereDoesntHave('sales')
            ->orderBy('full_name')
            ->get();

        return [

            'customers' => $customers,

            'quantity' => $customers->count(),

        ];
    }
}
