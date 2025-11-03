<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapyResource extends JsonResource
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
            'name' => $this->name,
            'file' => $this->file ? asset($this->file) : null,
            
            // Creator info
            'user' => UserResource::make($this->whenLoaded('user')),
            
            // Album info
            'album' => $this->whenLoaded('album', fn() => [
                'id' => $this->album->id,
                'name' => $this->album->name,
            ]),
            
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
