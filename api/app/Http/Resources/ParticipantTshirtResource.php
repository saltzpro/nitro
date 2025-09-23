<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantTshirtResource extends JsonResource
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
            'event_shirt_id' => $this->event_shirt_id,
            'registration_id' => $this->registration_id,
            'size' => $this->size,
            'tshirt' => $this->tshirts,
        ];
    }
}
