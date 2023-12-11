<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illimunate\Http\Request;
use Stripe;

class StripePaymentController extends Controller
{
    //
    public function stripePost(Request $request) 
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
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => 'My First Test Charge (created for API docs)',
            ]);

            return response()->json([$response->status], 200);
        } catch (Exception $ex) {
            return response()->json([['response' => 'Error']], 500);
        }
    }
}