<?php

namespace App\Providers;

use App\Repositories\ProductRepository;
use App\Repositories\SalesCalculatorRepository;
use App\Service\ProductDataService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ProductDataService::class, function ($app) {
            return new ProductDataService(
                $app->make(ProductRepository::class),
                $app->make(SalesCalculatorRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
