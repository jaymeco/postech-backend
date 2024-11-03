<?php

namespace App\Providers;

use App\Infra\Repositories\Eloquent\CategoryEloquentRepository;
use App\Infra\Repositories\Eloquent\CustomerEloquentRepository;
use App\Infra\Repositories\Eloquent\OrderEloquentRepository;
use App\Infra\Repositories\Eloquent\ProductEloquentRepository;
use App\Infra\Repositories\Memory\CustomerMemoryRepository;
use Core\Application\Contracts\Repositories as RepositoriesContracts;
use Core\Application\Contracts\Services as ServiceContracts;
use Core\Application\Services\OrderService;
use Core\Application\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RepositoriesContracts\CustomerRepository::class => CustomerEloquentRepository::class,
        RepositoriesContracts\CategoryRepository::class => CategoryEloquentRepository::class,
        RepositoriesContracts\ProductRepository::class => ProductEloquentRepository::class,
        RepositoriesContracts\OrderRepository::class => OrderEloquentRepository::class,

        ServiceContracts\OrderService::class => OrderService::class,
        ServiceContracts\ProductService::class => ProductService::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
