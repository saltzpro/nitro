<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ParticipantTshirtResource;

class RegistrationResource extends JsonResource
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
            'transaction_number' => $this->transaction_number,
            'event' => $this->selected_event,
            'category' => $this->selected_category,
            'event_category_total' => $this->event_category_total,
            'admin_fees' => $this->admin_fees,
            'total_payment' => $this->event_category_total + $this->admin_fees,
            'pickup_notes' => $this->pickup_notes,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'organization' => $this->organization,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'emergency_contact_person' => $this->emergency_contact_person,
            'emergency_relationship' => $this->emergency_relationship,
            'emergency_contact_number' => $this->emergency_contact_number,
            'tshirts' => ParticipantTshirtResource::collection($this->tshirts),
            'event_status' => $this->event_status,
            'participant_logs' => $this->participant_logs
        ];
    }
}
