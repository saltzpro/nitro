<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'description', 'event_start', 'event_end', 'location', 'fb_link', 'event_waiver', 'terms_and_condition', 'pickup_notes'
    ];
    
    public function ages() {
        return $this->hasMany(EventAge::class);
    }

    public function categories() {
        return $this->hasMany(EventCategory::class);
    }

    public function shirts() {
        return $this->hasMany(EventShirt::class);
    }

    public function pickups() {
        return $this->hasMany(EventPickup::class);
    }

}
