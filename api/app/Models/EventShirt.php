<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventShirt extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'shirt_title', 'shirt_description', 'shirt_sizes', 'shirt_images'
    ];
}
