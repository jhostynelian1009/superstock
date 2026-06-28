<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            if ($request->user()?->isClient()) {
                return redirect()->route('client.dashboard')
                    ->with('error', 'No tienes permisos de administrador.');
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
