<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        if ($this->by == "client")
        {
            $by = $this->customer->user->name;
            $to = $this->supplier->name;
        }else
        {
            $by = $this->supplier->name;
            $to = $this->customer->user->name;
        }

        return [
            'code' => $this->id,
            'by' => $this->by. ' - ' .$by,
            'to' => $to,
            'message' => $this->content,
            'send_date' => $this->updated_at
        ];
    }
}
