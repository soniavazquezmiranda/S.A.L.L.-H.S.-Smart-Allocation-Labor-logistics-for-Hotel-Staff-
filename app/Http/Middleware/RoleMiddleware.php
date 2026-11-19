<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Acceso total sin restricciones para el rol Admin
        if (Auth::user()->role === 'Admin') {
            return $next($request);
        }

        // Soportar múltiples roles separados por coma (ej. role:Recepcion,Limpieza)
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        // Valida contra los roles en español del Seeder
        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Acceso denegado: Tu cuenta no tiene permisos para este panel.');
        }

        return $next($request);
    }
}