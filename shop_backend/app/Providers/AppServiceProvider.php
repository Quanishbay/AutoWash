<?php

namespace App\Providers;


//use App\Services\LogService;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
//    public function register(): void
//    {
//        $this->app->register(LogService::class, function ($app) {
//            return new LogService();
//        });
//    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
