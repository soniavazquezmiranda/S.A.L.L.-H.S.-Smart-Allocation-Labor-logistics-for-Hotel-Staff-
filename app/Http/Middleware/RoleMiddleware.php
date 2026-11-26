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

<<<<<<< Updated upstream
        // 1. Si es Admin, entra SIEMPRE sin mirar nada más
=======
        // [AÑADIDO] El Administrador tiene acceso total a todos los paneles del hotel
>>>>>>> Stashed changes
        if (Auth::user()->role === 'Admin') {
            return $next($request);
        }

<<<<<<< Updated upstream
        // 2. Comprobamos el resto de roles permitidos en la ruta
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $role));
        }

        if (!in_array(Auth::user()->role, $allowedRoles)) {
=======
        // [MODIFICADO] Permite validar listas de roles (ej: role:Recepcion,Recepcion_Jefe,Admin)
        if (!in_array(Auth::user()->role, $roles)) {
>>>>>>> Stashed changes
            abort(403, 'Acceso denegado: Tu cuenta no tiene permisos para este panel.');
        }

        return $next($request);
    }
}