<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $slug = Str::slug($this->title) . '-' . $this->id;
        return [
            'id' => $this->id,
            'categories' => $this->categories,
            'user_id' => $this->user_id,
            'slug_name' => $slug,
            'title' => $this->title,
            'description' => $this->description,
            'shirts' => $this->shirts,
            'ages' => $this->ages,
            'event_start' => Carbon::parse($this->event_start)->format('l, F d, Y'),
            'event_start_at' => $this->event_start . ' 00:00:00Z',
            'event_end' => $this->event_end,
            'location' => $this->location,
            'fb_link' => $this->fb_link,
            'event_waiver' => $this->event_waiver,
            'terms_and_condition' => $this->terms_and_condition,
            'pickup_notes' => $this->pickup_notes,
            'pickups' => $this->pickups,
            'event_banner' => $this->event_banner
        ];
    }
}
