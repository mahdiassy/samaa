<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'status' => $this->status,
            'status_label' => $this->status_label, // Uses accessor
            'reason' => $this->reason,
            
            // Patient info
            'patient' => PatientResource::make($this->whenLoaded('patient')),
            
            // Availability & Doctor info
            'availability' => $this->whenLoaded('availability', fn() => [
                'id' => $this->availability->id,
                'time' => $this->availability->time->toISOString(),
                'doctor' => DoctorResource::make($this->whenLoaded('availability.doctor')),
            ]),
            
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
