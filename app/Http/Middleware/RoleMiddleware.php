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

        // [AÑADIDO] El Administrador tiene acceso total a todos los paneles del hotel
        if (Auth::user()->role === 'Admin') {
            return $next($request);
        }

        // [MODIFICADO] Permite validar listas de roles (ej: role:Recepcion,Recepcion_Jefe,Admin)
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Acceso denegado: Tu cuenta no tiene permisos para este panel.');
        }

        return $next($request);
    }
}
