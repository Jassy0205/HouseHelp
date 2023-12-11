<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\ContractStoreRequest;
use App\Http\Resources\api\v1\ContractAllResource;
use App\Http\Resources\api\v1\ContractResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Contract;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource to admin
     */
    public function list()
    {
        $contratos = Contract::all();
        return response()->json(['data' => ContractResource::collection($contratos)], 200);
    }

    /**
     * Display the specified resource to admin
     */
    public function ShowSinParametros(string $idcontrato)
    {
        $contrato = Contract::where('id', $idcontrato)->first();
        return response()->json(['data' => new ContractResource($contrato)], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            $contratos = $customer->contracts->where('provider', $id);
            return response()->json(['data' => ContractAllResource::collection($contratos)], 200); 
        }
        else if ($supplier != null)
        {
            $contratos = $supplier->contracts->where('client', $id);
            return response()->json(['data' => ContractAllResource::collection($contratos)], 200); 
        }   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, ContractStoreRequest $request)
    {
        $supplier = Supplier::where('email', Auth::user()->email)->first();
        $customer = Customer::find($id);

        if ($customer != null)
        {
            $contrato = Contract::create($request->all());

            $contrato['provider'] = $supplier["id"];
            $contrato['client'] = $id;

            $contrato -> save();
            return response()->json(['data' => new ContractResource($contrato)], 200);
        }else
            return response()->json(null, 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $idcontrato)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $contrato = Contract::where('provider', $id)->where('id', $idcontrato)->first();
            $customer = Customer::where('info_personal', $user->id)->first();

            if ($contrato['client'] == $customer['id'])
                return response()->json(['data' => new ContractResource($contrato)], 200);
        }
        else if ($supplier != null)
        {
            $contrato = Contract::where('client', $id)->where('id', $idcontrato)->first();
            if ($contrato['provider'] == $supplier['id'])
                return response()->json(['data' => new ContractResource($contrato)], 200);   
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request, string $idcontrato)
    {
        $user = Auth::user();
        $contrato = Contract::where('provider', $id)->where('id', $idcontrato)->first();

        if ($user['type'] == 'cliente' and $contrato['provider'] == $id)
        {
            $customer = Customer::where('info_personal', $user->id)->first();

            try {
                $request->validate([
                    'status' => 'required|ascii|in:aceptado,rechazado,en revision', // Permitir que sea nulo o contener un string válido
                ]);
            
                if ($request->has('status') and $contrato['status'] == 'en revision') {
                    $contrato->update(['status' => $request->input('status')]);
                }
                
                if ($contrato['status'] == 'aceptado') {
                    $linkCheckout = $this->checkout($id, $idcontrato);
                    return response()->json(['data' => $linkCheckout], 200);
                } else {
                    return response()->json(['data' => new ContractAllResource($contrato)], 200);
                }
                

            } catch (ValidationException $e) {
                return response()->json(['message' => $e->getMessage()], $e->status);
            }    
        }
    }

    public function checkout(string $id, string $idcontrato)
    {
        // validate status is accepted
        $user = Auth::user();
        $contrato = Contract::where('provider', $id)->where('id', $idcontrato)->first();

        // redirect to stripe
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $LineItems = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $contrato->description,
                ],
                'unit_amount' => $contrato->price,
            ],
            'quantity' => 1,
        ];

        
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [$LineItems],
                'mode' => 'payment',
                'success_url' => 'https://example.com/success',
                'cancel_url' => 'https://example.com/cancel',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
        // return stripe checkout link
        return response()->json(['message' => $session->url], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idcontrato)
    {
        $contrato = Contract::where('id', $idcontrato)->first();
        $contrato -> delete();
        return response()->json(null, 204);
    }
}
