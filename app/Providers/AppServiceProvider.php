<?php

namespace App\Providers;

use App\Models\CarType;
use App\Models\Province;
use App\Repositories\Contract\ContractRepository;
use App\Repositories\Contract\ContractRepositoryInterface;
use App\Repositories\ContractDriver\ContractDriverRepository;
use App\Repositories\ContractDriver\ContractDriverRepositoryInterface;
use App\Repositories\Request\RequestRepository;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\RequestDestination\RequestDestinationRepository;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            RequestRepositoryInterface::class,
            RequestRepository::class
        );

        $this->app->singleton(
            RequestDestinationRepositoryInterface::class,
            RequestDestinationRepository::class
        );

        $this->app->singleton(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            ContractRepositoryInterface::class,
            ContractRepository::class
        );

        $this->app->singleton(
            ContractDriverRepositoryInterface::class,
            ContractDriverRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
