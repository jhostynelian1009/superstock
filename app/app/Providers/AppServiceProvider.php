<?php

namespace App\Providers;

use App\Models\AdminAccessRequest;
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
            $pendingAdminRequests = 0;
            $adminNotifications = [];

            if ($user?->isPrimaryAdmin()) {
                $pendingAdminRequests = AdminAccessRequest::query()
                    ->where('status', AdminAccessRequest::STATUS_PENDING)
                    ->count();

                $adminNotifications = AdminAccessRequest::query()
                    ->where('status', AdminAccessRequest::STATUS_PENDING)
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn (AdminAccessRequest $request) => [
                        'texto' => $request->name.' solicita acceso de administrador',
                        'tiempo' => $request->created_at->diffForHumans(),
                        'tipo' => 'warning',
                        'url' => route('admin.solicitudes-admin.index'),
                    ])
                    ->all();
            }

            $view->with([
                'pendingAdminRequests' => $pendingAdminRequests,
                'adminNotifications' => $adminNotifications,
                'currentAdminUser' => $user,
            ]);
        });
    }
}
