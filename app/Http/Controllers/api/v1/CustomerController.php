<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\UserStoreRequest;
use App\Http\Requests\api\v1\UserUpdateRequest;
use App\Http\Resources\api\v1\CustomerResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with(['user' => function ($query) {
            $query->orderBy('name', 'asc');
        }])->get();

        return response()->json(['data' => CustomerResource::collection($customers)], 200); //Código de respuesta
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $email = $request->input('email');
        $existeUsuario = User::where('email', $email) ->where('type', 'customer') ->exists();

        if ($existeUsuario)
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
        else
        {
            $user = User::create($request->all());
            $customer = new Customer();

            $customer['info_personal'] = $user['id'];
            $customer->user()->associate($user);

            $customer->save();

            return response()->json(['data' => new CustomerResource($customer)], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $customer = Customer::where('info_personal', $user->id)->first();
        return response()->json(['data' => new CustomerResource($customer)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $user -> update($request->all());
        
        $customer = Customer::where('info_personal', $user->id)->first();
        return response()->json(['data' => new CustomerResource($customer)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        #$customer -> delete();

        #return response()->json(null, 204); //Codigo de error para "No content"
    }
}
