<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Validacion de roles generados por el Seeder
        if (Auth::user()->role !== $role) {
            abort(403, 'Acceso denegado: Tu cuenta no tiene permisos para este panel.');
        }

        return $next($request);
    }
}
