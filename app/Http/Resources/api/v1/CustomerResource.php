<?php

namespace App\Http\Resources\api\v1;

use App\Models\location;
use App\Models\User;
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
        $user = User::find($this->info_personal);
        #return parent::toArray($request);
        return [
            'code' => $this->id,
            'identification' => $user->identification_card,
            'full_name'  => $user->name. ' ' .$user->lastname, #Concatenación: $user->firstname . ' '. $user->lastname
            'username'  => $user->email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'creation_date' => $user->updated_at,
            'home' => new LocationResource($this->location)
        ];
    }
}
