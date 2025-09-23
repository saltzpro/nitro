<?php

namespace App\Models;

use App\Models\ParticipantLog;
use App\Models\ParticipantTshirt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'event_id',
        'event_category_id',
        'event_category_total',
        'admin_fees',
        'event_pickup_id',
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'organization',
        'email',
        'contact_number',
        'gender',
        'dob',
        'emergency_contact_person',
        'emergency_relationship',
        'emergency_contact_number'
    ];

    public function tshirts() {
        return $this->hasMany(ParticipantTshirt::class);
    }

    public function pickup_notes() {
        return $this->belongsTo(EventPickup::class, 'event_pickup_id');
    }

    public function selected_category() {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function selected_event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function participant_logs() {
        return $this->hasMany(ParticipantLog::class);
    }
}
