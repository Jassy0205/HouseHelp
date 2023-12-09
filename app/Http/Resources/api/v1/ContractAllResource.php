<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractAllResource extends JsonResource
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
            'Asunto' => 'Contrato laboral: ' . $this->description,
            'Client' => $this->customer->name. ' '. $this->customer->lastname,
            'Provider' => $this->supplier->name,
            'creation_date' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
