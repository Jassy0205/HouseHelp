<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\RatingUpdateRequest;
use App\Http\Requests\api\v1\RatingStoreRequest;
use App\Http\Resources\api\v1\RatingResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $ratings = Rating::where('provider', $id) -> get();

        return response()->json(['data' => RatingResource::collection($ratings)], 200); //Código de respuesta
    }

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        
        if ($supplier != null)
        {
            $ratings = $supplier->ratings;
            return response()->json(['data' => RatingResource::collection($ratings)], 200); //Código de respuesta
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, RatingStoreRequest $request)
    {
        $existeSupplier = Supplier::where('id', $id) ->exists();
        $user = Auth::user();

        if($existeSupplier)
        {
            $rating = Rating::create($request->all());
            $rating['client'] = $user["id"];
            $rating['provider'] = $id;

            $rating -> save();

            return response()->json(['data' => new RatingResource($rating)], 200);
        }else
            return response()->json(['message' => 'El correo electrónico ya está registrado'], Response::HTTP_CONFLICT);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $idrating)
    {
        $rating = Rating::where('id', $idrating)->where('provider', $id)->first();
        
        return response()->json(['data' => new RatingResource($rating)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, RatingUpdateRequest $request, string $idrating)
    {
        $user = Auth::user();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            
            $rating = Rating::where('id', $idrating)->where('client', $customer['id'])->where('provider', $id)->first();
            $rating -> update($request->all());

            return response()->json(['data' => new RatingResource($rating)], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idrating)
    {
        $user = Auth::user();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            $rating = Rating::where('id', $idrating)->where('client', $customer['id'])->first();

            $rating -> delete();
            return response()->json(null, 204);
        }
    }
}
