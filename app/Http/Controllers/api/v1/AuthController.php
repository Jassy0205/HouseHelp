<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar que el usuario haya provisto los datos necesarios
        // para hacer la autenticación: "email" y "password".
        try {
            $request->validate([
                'tipo' => 'required|in:customer,supplier',
                'password' => 'required|string|min:7',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], $e->status);
        }

        if ($request['tipo'] == 'customer')
        {
            try {
                $validator = Validator::make($request->all(), [
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        Rule::exists('users')->where(function ($query) {
                            $query->where('type', 'cliente');
                        }),
                    ],
                ]);
            
                $validator->validate();
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }
        }else{
            try {
                $request->validate(['email' => 'required|string|email|max:255|exists:suppliers',]);
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }
        }

        // Verificar que los datos provistos sean los correctos y que
        // efectivamente el usuario se autentique con ellos utilizando
        // los datos de la tabla "users".
        if (!Auth::attempt($request->only('email', 'password')) and !Auth::guard('supplier')->attempt($request->only('email', 'password')))
        {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        if ($request['tipo'] == 'customer')
        {     
            // Una vez autenticado, obtener la información del usuario en sesión.
            $tokenType = 'Bearer';
            $user = User::where('email', $request['email'])->firstOrFail();

            // Borrar los tokens anteriores (tipo Bearer) del usuario para
            // evitar, en este caso, tenga mas de uno del mismo tipo.
            $user->tokens()->where('name', $tokenType)->delete();

            // Crear un nuevo token tipo Bearer para el usuario autenticado.
            $token = $user->createToken($tokenType);
        }else{
            // Una vez autenticado, obtener la información del usuario en sesión.
            $tokenType = 'Bearer';
            $supplier = Supplier::where('email', $request['email'])->firstOrFail();

            // Borrar los tokens anteriores (tipo Bearer) del usuario para
            // evitar, en este caso, tenga mas de uno del mismo tipo.
            $supplier->tokens()->where('name', $tokenType)->delete();

            // Crear un nuevo token tipo Bearer para el usuario autenticado.
            $token = $supplier->createToken($tokenType);
        }

        // Enviar el token recién creado al cliente.
        return response()->json(['token' => $token->plainTextToken, 'type' => $tokenType], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([ 'message' => 'Token revoked'], 200); 
    }
}
