<?php

namespace App\Http\Resources\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\api\v1\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        $user = User::where('email', Auth::user()->email)->where('type', 'cliente')->first();

        if ($user != null)
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'about us' => $this->description,
                'email' => $this->email,
                'owner'  => $this->owner,
                'phone'  => $this->phone,
                'creation_date'  => $this->updated_at->format('Y-m-d'),
                'location' => $this->location->department . ' - '. $this->location->city,
            ];
        }else
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'about us' => $this->description,
                'email' => $this->email,
                'owner'  => $this->owner,
                'phone'  => $this->phone,
                'creation_date'  => $this->updated_at->format('Y-m-d'),
                'location' => new LocationResource($this->location),
            ];
        }
    }
}
