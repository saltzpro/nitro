<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAge extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'age_from', 'age_to'
    ];
    
}
