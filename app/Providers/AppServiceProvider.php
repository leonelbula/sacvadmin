<?php

namespace App\Providers;

use App\Repositories\Contracts\AccountPayablePaymentRepositoryInterface;
use App\Repositories\Contracts\AccountReceivablePaymentRepositoryInterface;
use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use App\Repositories\Eloquent\AccountReceivablePaymentRepository;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use App\Repositories\Contracts\ConfigurationRepositoryInterface;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\KardexRepository;
use App\Repositories\Contracts\KardexRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\InventoryAdjustmentRepositoryInterface;
use App\Repositories\Contracts\PosRepositoryInterface;
use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\SaleReturnRepositoryInterface;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Repositories\Contracts\ShoppingRepositoryInterface;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Repositories\Eloquent\TaxRepository;
use App\Repositories\Contracts\TaxRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AccountsPayableRepository;
use App\Repositories\Eloquent\AccountsReceivableRepository;
use App\Repositories\Eloquent\AcountPayablePaymentRepository;
use App\Repositories\Eloquent\ConfigurationRepository;
use App\Repositories\Eloquent\ExpenseRepository;
use App\Repositories\Eloquent\InventoryAdjustmentRepository;
use App\Repositories\Eloquent\PosRepository;
use App\Repositories\Eloquent\ReportRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\SaleReturnRepository;
use App\Repositories\Eloquent\SaleRepository;
use App\Repositories\Eloquent\ShoppingRepository;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Eloquent\UserRepository;

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
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(AccountsReceivableRepositoryInterface::class, AccountsReceivableRepository::class);
        $this->app->bind(AccountReceivablePaymentRepositoryInterface::class, AccountReceivablePaymentRepository::class);
        $this->app->bind(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);
        $this->app->bind(AccountsPayableRepositoryInterface::class, AccountsPayableRepository::class);
        $this->app->bind(AccountPayablePaymentRepositoryInterface::class, AcountPayablePaymentRepository::class);
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
