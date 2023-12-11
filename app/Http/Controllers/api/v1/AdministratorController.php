<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\UserStoreRequest;
use App\Http\Requests\api\v1\UserUpdateRequest;
use App\Http\Resources\api\v1\AdministratorResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrator;
use Illuminate\Http\Request;
use App\Models\User;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administrators = Administrator::with(['user' => function ($query) {
            $query->orderBy('name', 'asc');
        }])->get();
    
        return response()->json(['data' => AdministratorResource::collection($administrators)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $email = $request->input('email');
        $existeUsuario = User::where('email', $email)->where('type', 'admin')->exists();

        if ($existeUsuario) {
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
        } else {
            $user = User::create($request->all());
            $administrator = new Administrator();

            $administrator['info_personal'] = $user['id'];
            $administrator->user()->associate($user);

            $administrator->save();

            return response()->json(['data' => new AdministratorResource($administrator)], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser && $authenticatedUser->type === 'admin') {
            $administrator = Administrator::where('info_personal', $authenticatedUser->id)->first();
            return response()->json(['data' => new AdministratorResource($administrator)], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser && $authenticatedUser->type === 'admin') {
            $authenticatedUser->update($request->all());

            $administrator = Administrator::where('info_personal', $authenticatedUser->id)->first();

            return response()->json(['data' => new AdministratorResource($administrator)], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser && $authenticatedUser->type === 'admin') {
            $authenticatedUser->administrator->delete();

            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
}
