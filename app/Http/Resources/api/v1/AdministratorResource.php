<?php

namespace App\Http\Resources\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class AdministratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->info_personal);

        return [
            'code' => $this->id,
            'identification' => $user->identification_card,
            'full_name'  => $user->name. ' ' .$user->lastname, #Concatenación: $user->firstname . ' '. $user->lastname
            'username'  => $user->email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'creation_date' => $user->updated_at,
        ];
    }
}
