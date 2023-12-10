<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'id ' => $this->id,
            'To' => $this->supplier->name. ' - '. $this->supplier->email,
            'rating' => $this->star. ' estrellas: '. $this->comment,
            'by' => $this->customer->user->name. ' '. $this->customer->user->lastname,
            'creation_date' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
