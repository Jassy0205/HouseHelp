<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Message;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\MessageStoreRequest;
use App\Http\Requests\api\v1\MessageUpdateRequest;
use App\Http\Resources\api\v1\MessageResource;

class MessageController extends Controller
{
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
            $messages = Message::where('client', '=', $customer["id"]) -> where('provider', '=', $id) -> get();
            return response()->json(['data' => MessageResource::collection($messages)], 200); 
        }
        else if($supplier != null)
        {
            $messages = Message::where('provider', '=', $supplier["id"]) -> where('client', '=', $id) -> get();
            return response()->json(['data' => MessageResource::collection($messages)], 200); 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, MessageStoreRequest $request)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();

            $message = Message::create($request->all());
            $message['by'] = "client";
            $message['provider'] = $id;
            $message['client'] = $customer["id"];

            $message -> save();

            return response()->json(['data' => new MessageResource($message)], 200); 
        }
        else if ($supplier != null)
        {
            $message = Message::create($request->all());
            $message['by'] = "provider";
            $message['provider'] = $supplier["id"];
            $message['client'] = $id;

            $message -> save();

            return response()->json(['data' => new MessageResource($message)], 200); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Message $message)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            if ($message['provider'] == $id and $message['client'] == $customer["id"])
                return response()->json(['data' => new MessageResource($message)], 200);
        }
        else if ($supplier != null)
        {
            if ($message['client'] == $id and $message['provider'] == $supplier["id"])
                return response()->json(['data' => new MessageResource($message)], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Message $message)
    {
        $user = Auth::user();
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($user['type'] == 'cliente')
        {
            $customer = Customer::where('info_personal', $user->id)->first();
            if ($message['provider'] == $id and $message['client'] == $customer["id"])
            {
                $message -> delete();
                return response()->json(null, 204);
            }else{
                return response()->json(null, 404);
            }
        }
        else if($supplier != null)
        {
            if ($message['client'] == $id and $message['provider'] == $supplier["id"])
            {
                $message -> delete();
                return response()->json(null, 204);
            }else{
                return response()->json(null, 404);
            }
        } 
    }
}
