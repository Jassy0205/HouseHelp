<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\api\v1\SupplierResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Rating;

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
    public function destroy(string $id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
        }

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['data' => 'Proveedor no encontrado.'], 404);
        }

        $supplier->delete();

        return  response()->json(['data' => 'Proveedor eliminado correctamente'], 200);
    }

    /**
     * Suspende a un proveedor debido a sus bajas calificaciones
     */
    public function checkAndSuspendSupplier(string $supplierId)
    {
        $user = Auth::user();

        if ($user['type'] == 'admin')
        {
            $supplier = Supplier::find($supplierId);

            if (!$supplier) {
                return response()->json(['data' => 'Proveedor no encontrado.'], 404);
            }
    
            $lowRatings = Rating::where('provider', $supplierId)->where('star', '<', 2.5)->get();
    
            if ($lowRatings->count() >= 3) {
                $supplier->update(['suspended' => true]);
                return response()->json(['data' => 'Proveedor suspendido debido a múltiples calificaciones bajas', new SupplierResource($supplier)], 200);
            }
    
            return response()->json(['data' => 'Proveedor no suspendido', new SupplierResource($supplier)], 200);
        }else
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }
}
