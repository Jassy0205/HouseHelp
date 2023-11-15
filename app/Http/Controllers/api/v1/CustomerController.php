<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\CustomerStoreRequest;
use App\Http\Requests\api\v1\CustomerUpdateRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('name', 'asc') -> get();

        return response()->json(['data' => $customers], 200); //Código de respuesta
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $customer = Customer::create($request->all());

        return response()->json(['data' => $customer], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json(['data' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
