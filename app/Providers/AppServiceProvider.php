<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\ExternalJobFeedInterface::class,
            \App\Services\MrgeJobFeedService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();

        Date::use(CarbonImmutable::class);
    }
}
