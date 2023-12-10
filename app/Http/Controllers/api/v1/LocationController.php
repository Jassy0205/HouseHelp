<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\LocationStoreRequest;
use App\Http\Requests\api\v1\LocationUpdateRequest;
use App\Http\Resources\api\v1\LocationResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\location;
use App\Models\Customer;
use App\Models\Supplier;

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
    public function store(LocationStoreRequest $request)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            if ($customer['home'] == null)
            {
                $location = Location::create($request->all());
                $location->customer()->associate($customer);
                $location->save();

                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }else if($supplier != null)
        {
            if ($supplier['company'] == null)
            {
                $location = Location::create($request->all());
                $location->suppliers()->associate($supplier);
                $location->save();

                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            if ($customer['home'] != null)
            {
                $location = Location::find($customer['home']);
                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }else if($supplier != null)
        {
            if ($supplier['company'] != null)
            {
                $location = Location::find($supplier['company']);
                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationUpdateRequest $request)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            if ($customer['home'] != null)
            {
                $location = Location::find($customer['home']);
                $location -> update($request->all());
                
                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }else if($supplier != null)
        {
            if ($supplier['company'] != null)
            {
                $location = Location::find($supplier['company']);
                $location -> update($request->all());

                return response()->json(['data' => new LocationResource($location)], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
