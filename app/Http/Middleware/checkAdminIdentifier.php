<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkAdminIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // Ejemplo de middleware para verificar el rol de administrador
    public function handle($request, Closure $next)
    {
        $user = User::where('email', Auth::user()->email)->where('type', 'admin')->first();

        if ($user != null)
        {
            return $next($request);
        }

        return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }

}
