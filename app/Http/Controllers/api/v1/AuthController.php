<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar que el usuario haya provisto los datos necesarios
        // para hacer la autenticación: "email" y "password".
        try {
            $request->validate([
            'email' => 'required|string|email|max:255|exists:customers',
            'password' => 'required|string|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], $e->status);
        }

        // Verificar que los datos provistos sean los correctos y que
        // efectivamente el usuario se autentique con ellos utilizando
        // los datos de la tabla "users".
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
            'message' => 'Invalid login details'
            ], 401);
        }

        // Una vez autenticado, obtener la información del usuario en sesión.
        $tokenType = 'Bearer';
        $customer = Customer::where('email', $request['email'])->firstOrFail();

        // Borrar los tokens anteriores (tipo Bearer) del usuario para
        // evitar, en este caso, tenga mas de uno del mismo tipo.
        $customer->tokens()->where('name', $tokenType)->delete();

        // Crear un nuevo token tipo Bearer para el usuario autenticado.
        $token = $customer->createToken($tokenType);

        // Enviar el token recién creado al cliente.
        return response()->json(['token' => $token->plainTextToken, 'type' => $tokenType], 200);
    }

    public function logout(Request $request)
    {
        $request->customer()->currentAccessToken()->delete();

        return response()->json([ 'message' => 'Token revoked'], 200); 
    }
}
