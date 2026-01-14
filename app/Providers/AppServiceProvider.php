<?php

namespace App\Providers;

use App\Facades\ApiResponse;
use App\Facades\FacadesLogic\ApiResponseLogic;
use App\Facades\FacadesLogic\FileHandlerLogic;
use App\Facades\FileHandler;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Models\Subscription;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ApiResponse::class,
            ApiResponseLogic::class
        );
        $this->app->bind(
            FileHandler::class,
            FileHandlerLogic::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);
        
        view()->composer('*', function ($view) {
        $pendingSubscriptionsCount = Subscription::where('status', 'pending')->count();
        $view->with('pendingSubscriptionsCount', $pendingSubscriptionsCount);
    });
    }
}
