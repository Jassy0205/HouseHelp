<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\SupplierStoreRequest;
use App\Http\Resources\api\v1\CustomerResource;
use App\Http\Resources\api\v1\SupplierResource;
use App\Http\Resources\api\v1\AdministratorResource;
use App\Http\Requests\api\v1\UserStoreRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\User;


use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar que el usuario haya provisto los datos necesarios
        // para hacer la autenticación: "email" y "password".
        try {
            $request->validate([
                'type' => 'required|in:customer,supplier,administrator',
                'password' => 'required|string|min:7',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], $e->status);
        }

        if ($request['type'] == 'customer')
        {
            try {
                $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email','max:255',
                        Rule::exists('users')->where(function ($query) {
                            $query->where('type', 'cliente');
                        }),
                    ],
                ]);
            
                $validator->validate();
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }
        }else if ($request['type'] == 'administrator')
        {
            try {
                $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email','max:255',
                        Rule::exists('users')->where(function ($query) {
                            $query->where('type', 'admin');
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
        $password = md5($request->input('password'));

        if (!Auth::attempt(['email' => $request->input('email'), 'password' => $password]) && !Auth::guard('supplier')->attempt(['email' => $request->input('email'), 'password' => $password])) 
        {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        //if (!Auth::attempt($request->only('email', 'password')) and !Auth::guard('supplier')->attempt($request->only('email', 'password')))
        //{
        //    return response()->json(['message' => 'Invalid login details'], 401);
        //}

        if ($request['type'] == 'customer')
        {     
            // Una vez autenticado, obtener la información del usuario en sesión.
            $tokenType = 'Bearer';
            $user = User::where('email', $request['email'])->firstOrFail();

            // Borrar los tokens anteriores (tipo Bearer) del usuario para
            // evitar, en este caso, tenga mas de uno del mismo tipo.
            if ($user['type'] == 'customer'){
                $user->tokens()->where('name', $tokenType)->delete();
            }
            
            $token = $user->createToken($tokenType);
        }else if($request['type'] == 'administrator')
        {
            // Una vez autenticado, obtener la información del usuario en sesión.
            $tokenType = 'Bearer';
            $user = User::where('email', $request['email'])->firstOrFail();

            // Borrar los tokens anteriores (tipo Bearer) del usuario para
            // evitar, en este caso, tenga mas de uno del mismo tipo.
            if ($user['type'] == 'admin')
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

    public function registerCustomer(UserStoreRequest $request)
    {
        $email = $request->input('email');
        $existeUsuario = User::where('email', $email)->where('type', 'cliente') ->exists();

        if ($existeUsuario)
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
        else
        {
            $hashedPassword = md5($request->input('password'));
            $userData = $request->all();
            $userData['password'] = $hashedPassword;

            $user = User::create($userData);
            $customer = new Customer();

            $customer['info_personal'] = $user['id'];
            $customer->user()->associate($user);
            $customer->save();

            return response()->json(['data' => new CustomerResource($customer)], 200);
        }
    }

    public function registerSupplier(SupplierStoreRequest $request)
    {
        $email = $request->input('email');
        $existeSupplier = Supplier::where('email', $email)->exists();

        if ($existeSupplier)
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
        else
        {
            $hashedPassword = md5($request->input('password'));

            $supplierData = $request->all();
            $supplierData['password'] = $hashedPassword;

            $supplier = Supplier::create($supplierData);
            return response()->json(['data' => new SupplierResource($supplier)], 200);
        }
    }

    public function registerAdministrator(UserStoreRequest $request)
    {
        $email = $request->input('email');
        $existeUsuario = User::where('email', $email)->where('type', 'admin') ->exists();

        if ($existeUsuario) {
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
        } else {
            $hashedPassword = md5($request->input('password'));
            $userData = $request->all();
            $userData['password'] = $hashedPassword;

            $user = User::create($userData);
            $administrator = new Administrator();

            $administrator['info_personal'] = $user['id'];
            $administrator->user()->associate($user);

            $administrator->save();

            return response()->json(['data' => new AdministratorResource($administrator)], 200);
        }
    }
}
