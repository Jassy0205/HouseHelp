<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('email', Auth::user()->email)->where('type', 'cliente')->first();
        $user2 = User::where('email', Auth::user()->email)->where('type', 'admin')->first();

        if ($user != null || $user2 != null) {
            return $next($request);
        }

        return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    
    }
}
