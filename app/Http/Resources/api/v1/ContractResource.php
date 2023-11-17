<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'Asunto' => 'Contrato laboral',
            'Lugar de efecto' => $this->customer->location->department. ' - ' .$this->customer->location->city,
            'content'  => 'Este contrato de '. $this->description .', celebrado el'. $this->created_at .' entre'. $this->supplier->name. 
                    ' y la/el señor(a) ' .$this->customer->name. ' '. $this->customer->lastname.' identificad@ con número de cédula '.
                    $this->customer->identification_card. ' por el valor de '.$this->price,
        ];
    }
}
