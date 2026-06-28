<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
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
        view()->composer('layouts.public', function ($view): void {
            $cart = Session::get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));

            $view->with([
                'cartCount' => $cartCount,
                'cartTotal' => array_reduce($cart, fn (float $sum, array $item) => $sum + ($item['price'] * $item['quantity']), 0.0),
            ]);
        });

        view()->composer('layouts.admin', function ($view): void {
            $user = auth()->user();

            $view->with([
                'pendingAdminRequests' => 0,
                'adminNotifications' => [],
                'currentAdminUser' => $user,
            ]);
        });
    }
}
