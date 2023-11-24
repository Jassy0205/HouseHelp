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
        $customer = Customer::where('email', Auth::user()->email)->first();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        $atributosPivote = [];

        if ($supplier == null)
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
        else
        {
            foreach ($supplier->applications as $app) {
                $status = $app->pivot->status;

                if ($status != 'rechazada')
                    $atributosPivote[] = $app;
            }

            return response()->json(['data' => ApplicationResource::collection($atributosPivote)], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationStoreRequest $request)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        $application = Application::create($request->all());

        if ($supplier == null)
        {
            $application['client'] =  $customer["id"];
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
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($supplier == null)
        {
            if ($application['client'] ==  $customer["id"])
            {
                foreach ($application->suppliers as $sup) {
                    $status = $sup->pivot->status;
                }

                return response()->json(['data' => new ApplicationResource($application)], 200);
            } 
        }
        else
        {
            foreach ($supplier->applications as $app) {
                $status = $app->pivot->status;

                if ($status != 'rechazada' and $app['id'] == $application['id'])
                    return response()->json(['data' => new ApplicationResource($app)], 200);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($supplier == null)
        {
            $application -> update($request->all());
            return response()->json(['data' => new ApplicationResource($application)], 200); 
        } else
        {
            try {
                $request->validate([
                    'status' => 'required|string|min:8|max:9|ascii',
                ]);
            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }
            
            //$supplierApp = SupplierApplication::where('provider' '=' $supplier['id']) -> where('publishing' '=' $application['id']) -> get();
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
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $customer = Customer::where('email', Auth::user()->email)->first();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($supplier == null)
        {
            $suppliers = Supplier::all();

            foreach ($suppliers as $sup) {
                $supplierApp = SupplierApplication::where('provider', '=', $sup['id']) -> where('publishing', '=', $application['id']) -> delete();
                $application->suppliers()->detach($sup['id']);
                $application -> delete();
            }

            return response()->json(null, 204); 
        }
    }
}
