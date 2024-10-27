<?php

namespace App\Providers;

use App\Infra\Repositories\Eloquent\CustomerEloquentRepository;
use App\Infra\Repositories\Memory\CustomerMemoryRepository;
use Core\Application\Contracts\Repositories as RepositoriesContracts;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RepositoriesContracts\CustomerRepository::class => CustomerEloquentRepository::class,
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
