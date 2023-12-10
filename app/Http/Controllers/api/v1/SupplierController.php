<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\api\v1\SupplierResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name', 'asc') -> get();

        return response()->json(['data' => SupplierResource::collection($suppliers)], 200); //Código de respuesta
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
    public function show()
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        return response()->json(['data' => new SupplierResource($supplier)], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        $supplier-> update($request->all());
        $supplier->save();
        return response()->json(['data' => new SupplierResource($supplier)], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
