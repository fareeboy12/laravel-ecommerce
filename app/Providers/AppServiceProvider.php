<?php

namespace App\Providers;

use App\Http\View\Composers\CartComposer;
use App\Http\ViewComposers\WishlistComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        // Share the cart data with the header view
        View::composer('layouts.header', CartComposer::class);
        View()->composer('header', WishlistComposer::class);
    }
}
