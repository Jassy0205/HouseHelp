<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkAdminIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle($request, Closure $next)
    {
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
    }

}
