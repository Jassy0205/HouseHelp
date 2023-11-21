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
            'id ' => $this->id. ', To: '. $this->provider,
            'n' => $this->start. ': '. $this->comment,
            'by' => $this->client,
            'creation_date' => $this->updated_at,
        ];
    }
}
