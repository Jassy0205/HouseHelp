<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\StripePayment;
use Illuminate\Http\Request;
use Stripe;
use Exception;
use App\Models\Contract;

class StripePaymentController extends Controller
{

    public function checkout(string $idsupplier, Request $request, string $idcontrato) 
    {
        $contrato = Contract::where('provider', $idsupplier)->where('id', $idcontrato)->first();

        if ($contrato['status'] == 'aceptado')
        {
            try {
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );
                $res = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                    ],
                ]);
    
                Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
    
                $response = $stripe->charges->create([
                    'amount' => $contrato->price,
                    'currency' => 'usd',
                    'source' => $res->id,
                    'description' => $contrato->description,
                ]);
    
                return response()->json([$response->status], 201);
            } catch (Exception $ex) {
                return response()->json([['response' => $ex->getMessage()]], 500);
            }
        } else {
            return response()->json(['response' => 'Falta aceptar el contrato'], 403);
        }


    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(StripePayment $stripePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StripePayment $stripePayment)
    {
        //
    }

}
