<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantTshirt extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_shirt_id', 'size', 'registration_id'
    ];

    public function tshirts() {
        return $this->belongsTo(EventShirt::class, 'event_shirt_id');
    }

}
