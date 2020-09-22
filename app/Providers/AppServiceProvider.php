<?php

namespace App\Providers;

use App\Models\CarType;
use App\Models\Province;
use App\Repositories\Request\RequestRepository;
use App\Repositories\Request\RequestRepositoryInterface;
use App\Repositories\RequestDestination\RequestDestinationRepository;
use App\Repositories\RequestDestination\RequestDestinationRepositoryInterface;
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
