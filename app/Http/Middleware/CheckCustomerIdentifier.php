<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerIdentifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('email', Auth::user()->email)->where('type', 'cliente')->first();

        if ($user != null)
        {
            return $next($request);
        }

        return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }
}
