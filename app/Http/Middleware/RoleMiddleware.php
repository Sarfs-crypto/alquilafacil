<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar que el usuario esté autenticado y tenga el rol correcto
        if (auth()->user()->role !== $role) {
            abort(403, 'Acceso denegado. No tienes permisos de administrador.');
        }

        return $next($request);
    }
}