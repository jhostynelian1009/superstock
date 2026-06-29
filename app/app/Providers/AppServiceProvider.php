<?php

namespace App\Providers;

use App\Models\AdminAccessRequest;
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
        \Illuminate\Auth\Middleware\RedirectIfAuthenticated::redirectUsing(function () {
            return route('admin.dashboard');
        });

        view()->composer('layouts.admin', function ($view): void {
            $user = auth()->user();
            $pendingAdminRequests = 0;
            $adminNotifications = [];

            if ($user?->isPrimaryAdmin()) {
                $pendingAdminRequests = AdminAccessRequest::query()->pending()->count();
                $adminNotifications = AdminAccessRequest::query()
                    ->pending()
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn (AdminAccessRequest $request) => [
                        'id'     => $request->id,
                        'name'   => $request->name,
                        'email'  => $request->email,
                        'texto'  => $request->name . ' solicita acceso de administrador',
                        'tiempo' => $request->created_at->diffForHumans(),
                        'tipo'   => 'warning',
                        'url'    => route('admin.solicitudes-admin.index'),
                    ])
                    ->all();
            }

            $view->with([
                'pendingAdminRequests' => $pendingAdminRequests,
                'adminNotifications'   => $adminNotifications,
                'currentAdminUser'     => $user,
            ]);
        });
    }
}
