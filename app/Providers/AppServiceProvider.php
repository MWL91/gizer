<?php

namespace App\Providers;

use App\Services\ResultsService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ResultsServiceContract;
use App\Contracts\ResultsApiRepositoryContract;
use App\Repositories\Rest\ResultsApiRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResultsServiceContract::class, ResultsService::class);
        $this->app->bind(ResultsApiRepositoryContract::class, ResultsApiRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
