<?php

namespace App\Providers;

use App\Domain\Company\Repositories\CompanyRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\CompanyRepositoryEloquent;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CompanyRepository::class,
            CompanyRepositoryEloquent::class,
        );
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
