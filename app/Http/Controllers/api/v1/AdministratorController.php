<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); 
        $this->middleware('checkAdminIdentifier');
    }

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
            $administrator = Administrator::where('info_personal', authenticatedUser->id)->first();
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



    public function verifyCustomer(Customer $customer)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403, 'No tienes permisos para verificar clientes.');
        }

        $customer->update(['verified' => true]);

        return redirect()->back()->with('success', 'Cliente verificado correctamente.');
    }

    public function deleteCustomer($id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403, 'No tienes permisos para eliminar clientes.');
        }

        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }

        $customer->delete();

        return redirect()->back()->with('success', 'Cliente eliminado correctamente.');
    }

    public function deleteSupplier($id)
    {
        $admin = Auth::user();
        if ($admin->type !== 'admin') {
            abort(403, 'No tienes permisos para eliminar proveedores.');
        }

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->back()->with('error', 'Proveedor no encontrado.');
        }

        $supplier->delete();

        return redirect()->back()->with('success', 'Proveedor eliminado correctamente.');
    }

    public function checkAndSuspendSupplier($supplierId)
    {
        $admin = Auth::user();
        if ($admin->type !== 'administrator') {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $supplier = Supplier::find($supplierId);

        if (!$supplier) {
            return redirect()->back()->with('error', 'Proveedor no encontrado.');
        }

        $lowRatings = Rating::where('supplier', $supplierId)
            ->where('rating', '<', 2.5)
            ->get();

        if ($lowRatings->count() >= 3) {
            $supplier->update(['suspended' => true]);

            return redirect()->back()->with('success', 'Proveedor suspendido debido a múltiples calificaciones bajas.');
        }

        return redirect()->back()->with('success', 'Proveedor no suspendido.');
    }

}
