<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\location;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\LocationStoreRequest;
use App\Http\Requests\api\v1\LocationUpdateRequest;
use App\Http\Resources\api\v1\LocationResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::orderBy('department', 'asc') -> get();

        return response()->json(['data' => LocationResource::collection($locations)], 200); //Código de respuesta
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
