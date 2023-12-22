<?php

namespace App\Providers;

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $restaurantes = RestauranteController::getRestaurantes();
        View::share('restaurantes_array', $restaurantes);
        Schema::defaultStringLength(191);
    }
}
