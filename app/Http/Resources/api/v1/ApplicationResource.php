<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supplier;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $supplier = Supplier::where('email', Auth::user()->email)->first();

        if ($supplier != null)
        {
            $status = $this->pivot->status;

            return [
                'code' => $this->id,
                'description' => $this->description,
                'by' => $this->customer->user->name . ' '. $this->customer->user->lastname,
                'creation_date' => $this->updated_at,
                'status' => $status,
            ];
        }else
        {
            return [
                'code' => $this->id,
                'description' => $this->description,
                'by' => $this->customer->user->name . ' '. $this->customer->user->lastname,
                'creation_date' => $this->updated_at,
                'suppliers' => SupplierCustomerResource::collection($this->suppliers), 
            ];
        }
    }
}
