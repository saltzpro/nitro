<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentProofResource extends JsonResource
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
            'registration_id' => $this->registration_id,
            'amount' => $this->amount,
            'proof_path' => env('APP_URL') . '/' . $this->proof_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
