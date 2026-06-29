<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user?->isAdmin() && ! $user?->isEmployee()) {
            return redirect()->route('login');
        }

        // Check module permissions
        $routeName = $request->route()?->getName();
        if ($routeName) {
            $moduleMap = [
                'admin.productos.' => 'productos',
                'admin.categorias.' => 'categorias',
                'admin.proveedores.' => 'proveedores',
                'admin.inventario.' => 'inventario',
                'admin.usuarios.' => 'usuarios',
                'admin.movimientos.' => 'movimientos',
                'admin.solicitudes-admin.' => 'solicitudes-admin',
            ];

            foreach ($moduleMap as $prefix => $module) {
                if (str_starts_with($routeName, $prefix)) {
                    if (! $user->hasPermissionTo($module)) {
                        return redirect()->route('admin.dashboard')
                            ->with('error', 'No tienes permiso para acceder al módulo de ' . ucfirst($module) . '.');
                    }
                }
            }
        }

        return $next($request);
    }
}
