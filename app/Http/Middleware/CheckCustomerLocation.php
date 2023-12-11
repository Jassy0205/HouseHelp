<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $customer = Customer::where('info_personal', $user->id)->first();

        if ($customer['home'] != null)
        {
            return $next($request);
        }

        return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }
}
