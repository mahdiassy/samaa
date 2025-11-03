<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name, // Uses accessor
            'email' => $this->user?->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'birthday' => $this->birthday?->toDateString(),
            'age' => $this->age, // Uses accessor
            'image' => $this->image ? asset($this->image) : null,
            
            // Social media
            'social' => [
                'twitter' => $this->twitter,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
            ],
            
            // Availability
            'availabilities' => $this->whenLoaded('availabilities'),
            
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
