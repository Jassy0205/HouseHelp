<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSupplierLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($supplier['company'] != null and $supplier['suspended'] == false)
        {
            return $next($request);
        }

        return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }
}
