<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\ApplicationStoreRequest;
use App\Http\Resources\api\v1\ApplicationStoreResource; 
use App\Http\Resources\api\v1\ApplicationResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\SupplierApplication;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Customer;
use App\Models\Supplier;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        $customer = Customer::where('info_personal', $user->id)->first();
        $atributosPivote = [];

        if ($user['type'] == 'cliente' and $customer['verification'] == 'verificado')
        {
            foreach ($customer->applications as $app)
            {
                foreach ($app->suppliers as $sup) {
                    $status = $sup->pivot->status;
                }

                $atributosPivote[] = $app;
            }

            return response()->json(['data' => ApplicationResource::collection($atributosPivote)], 200); 
        }
        else if ($supplier != null)
        {
            foreach ($supplier->applications as $app) {
                if ($app->isPendiente())
                {
                    $status = $app->pivot->status;

                    if ($status != 'rechazada')
                        $atributosPivote[] = $app;
                }
            }

            return response()->json(['data' => ApplicationResource::collection($atributosPivote)], 200);
        }else
        {
            $aplicaciones = Application::all();
            return response()->json(['data' => ApplicationResource::collection($aplicaciones)], 200);
        }    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationStoreRequest $request)
    {
        $user = Auth::user();
        $application = Application::create($request->all());
        $customer = Customer::where('info_personal', $user->id)->first();

        if ($user['type'] == 'cliente' and $customer['verification'] == 'verificado')
        {
            $application['client'] = $customer["id"];
            $suppliers = Supplier::all();

            foreach ($suppliers as $sup) {
                $supplierAppData = [
                    'provider' => $sup['id'],
                    'publishing' => $application['id'],
                    'status' => 'revision' // Asegúrate de que el nombre del atributo sea correcto
                ];

                $application->suppliers()->attach($sup['id'], $supplierAppData);
            }

            $application -> save();
            return response()->json(['data' => new ApplicationResource($application)], 200); 
        }else
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        $customer = Customer::where('info_personal', $user->id)->first();

        if ($user['type'] == 'cliente' and $customer['verification'] == 'verificado')
        {
            if ($application['client'] == $customer["id"])
            {
                foreach ($application->suppliers as $sup) {
                    $status = $sup->pivot->status;
                }

                return response()->json(['data' => new ApplicationResource($application)], 200);
            }
        }
        else if ($supplier != null)
        {
            foreach ($supplier->applications as $app) {

                $status = $app->pivot->status;

                if ($status != 'rechazada' and $app['id'] == $application['id'] and $app->isPendiente())
                    return response()->json(['data' => new ApplicationResource($app)], 200);
            }
        }else
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        $customer = Customer::where('info_personal', $user->id)->first();
        $usuarioAplicacion = $application->customer->user;

        if ($user['type'] == 'cliente' and $user['id'] == $usuarioAplicacion['id'] and $customer['verification'] == 'verificado')
        {
            try {
                $request->validate([
                    'description' => 'nullable|string|max:300|ascii', // Permitir que sea nulo o contener un string válido
                    'resolucion' => 'nullable|string|ascii|in:pendiente,resuelta'
                ]);
            
                if ($request->has('description')) {
                    $application->update(['description' => $request->input('description')]);
                }
                if ($request->has('resolucion')) {
                    $application->update(['resolucion' => $request->input('resolucion')]);
                }
            
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }                
    
            return response()->json(['data' => new ApplicationResource($application)], 200);

        } else if ($supplier != null)
        {
            try {
                $request->validate([
                    'status' => 'required|string|min:8|max:9|ascii',
                ]);
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }
            
            $application->suppliers()->updateExistingPivot($supplier['id'], ['status' => $request['status']]);

            $atributosPivote = null;
            foreach ($application->suppliers as $app) {
                $status = $app->pivot->status;
                if ($app->pivot->publishing == $application['id'] and $app['id'] == $supplier['id'])
                {
                    $atributosPivote = $app;
                }
            }

            return response()->json(['data' => ApplicationResource::collection($atributosPivote)], 200);
        }else
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $user = Auth::user();
        $usuarioAplicacion = $application->customer->user;
        $customer = Customer::where('info_personal', $user->id)->first();

        if ($user['type'] == 'cliente' and $user['id'] == $usuarioAplicacion['id'] and $customer['verification'] == 'verificado')
        {
            $suppliers = Supplier::all();

            foreach ($suppliers as $sup) {
                $supplierApp = SupplierApplication::where('provider', '=', $sup['id']) -> where('publishing', '=', $application['id']) -> delete();
                $application->suppliers()->detach($sup['id']);
                $application -> delete();
            }

            return response()->json(null, 204); 
        }else
            return response()->json(['message' => 'No tienes acceso a esta ruta'], 403);
    }
}
