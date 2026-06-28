<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isClient()) {
            if ($request->user()?->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Esta sección es solo para clientes.');
            }

            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión como cliente para continuar.');
        }

        return $next($request);
    }
}
