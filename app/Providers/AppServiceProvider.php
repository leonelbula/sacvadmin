<?php

namespace App\Providers;

use App\Interfaces\ExpenseRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\KardexRepository;
use App\Interfaces\KardexRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\InventoryAdjustmentRepositoryInterface;
use App\Interfaces\PosRepositoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use App\Interfaces\SaleReturnRepositoryInterface;
use App\Interfaces\SaleRepositoryInterface;
use App\Interfaces\ShoppingRepositoryInterface;
use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\TaxRepository;
use App\Interfaces\TaxRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\ExpenseRepository;
use App\Repositories\InventoryAdjustmentRepository;
use App\Repositories\PosRepository;
use App\Repositories\ReportRepository;
use App\Repositories\SaleReturnRepository;
use App\Repositories\SaleRepository;
use App\Repositories\ShoppingRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(KardexRepositoryInterface::class, KardexRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(TaxRepositoryInterface::class, TaxRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(PosRepositoryInterface::class, PosRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(SaleReturnRepositoryInterface::class, SaleReturnRepository::class);
        $this->app->bind(InventoryAdjustmentRepositoryInterface::class, InventoryAdjustmentRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(ShoppingRepositoryInterface::class, ShoppingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
