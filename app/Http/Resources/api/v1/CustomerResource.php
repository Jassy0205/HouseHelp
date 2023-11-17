<?php

namespace App\Http\Resources\api\v1;

use App\Models\location;
use App\Http\Resources\api\v1\LocationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        #return parent::toArray($request);
        return [
            'identification' => $this->identification_card,
            'full_name'  => $this->name. ' ' .$this->lastname, #Concatenación: $this->firstname . ' '. $this->lastname
            'username'  => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'creation_date'  => $this->updated_at,
            'home' => new LocationResource($this->location)
        ];
    }
}
