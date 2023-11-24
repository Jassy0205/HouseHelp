<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'code' => $this->id,
            'company' => $this->name. ' - '. $this->email,
            'Actualizado' => $this->updated_at,
            'status' => $this->pivot->status,
        ];
    }
}
