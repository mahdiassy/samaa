<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'gender' => $this->gender,
            'blood_type' => $this->blood_type,
            'image' => $this->image ? asset($this->image) : null,
            
            // Social media
            'social' => [
                'twitter' => $this->twitter,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
            ],
            
            // Relationships
            'country' => $this->whenLoaded('country', fn() => [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ]),
            'language' => $this->whenLoaded('language', fn() => [
                'id' => $this->language->id,
                'name' => $this->language->name,
            ]),
            
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
