<?php

namespace App\Providers;

use App\Infra\Integrations\Http\GuzzleHttpClient;
use App\Infra\Integrations\Http\HttpClient;
use App\Infra\Integrations\LambdaAuthService;
use App\Infra\Integrations\MockPaymentService;
use App\Infra\Repositories\Eloquent\CategoryEloquentRepository;
use App\Infra\Repositories\Eloquent\CustomerEloquentRepository;
use App\Infra\Repositories\Eloquent\OrderEloquentRepository;
use App\Infra\Repositories\Eloquent\PaymentEloquentRepository;
use App\Infra\Repositories\Eloquent\ProductEloquentRepository;
use Core\Application\Contracts\Repositories as RepositoriesContracts;
use Core\Application\Contracts\Services as ServiceContracts;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RepositoriesContracts\CustomerRepository::class => CustomerEloquentRepository::class,
        RepositoriesContracts\CategoryRepository::class => CategoryEloquentRepository::class,
        RepositoriesContracts\ProductRepository::class => ProductEloquentRepository::class,
        RepositoriesContracts\OrderRepository::class => OrderEloquentRepository::class,
        RepositoriesContracts\PaymentRepository::class => PaymentEloquentRepository::class,

        ServiceContracts\PaymentService::class => MockPaymentService::class,
        ServiceContracts\AuthService::class => LambdaAuthService::class,
        HttpClient::class => GuzzleHttpClient::class,
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
