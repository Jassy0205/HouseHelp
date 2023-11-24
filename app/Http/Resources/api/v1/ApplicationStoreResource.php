<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStoreResource extends JsonResource
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
            'description' => $this->description,
            'by' => $this->customer->name . ' '. $this->customer->lastname,
            'creation_date' => $this->updated_at,
        ];
    }
}
