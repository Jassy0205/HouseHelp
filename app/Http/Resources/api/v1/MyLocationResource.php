<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->id,
            'department'  => $this->department,
            'city' => $this->city,
            'address'  => $this->address,
            'neighborhood' => $this->neighborhood,
            'specifications' => $this->specifications,
            'created_at' => $this->updated_at,
        ];
    }
}
