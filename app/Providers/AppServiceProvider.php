<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Views\Composers\ProductDataComposer;
use Illuminate\Support\Facades\View;

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
        View::composer(['front.index','front.products.listing'], ProductDataComposer::class);
    }
}
