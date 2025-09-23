<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantLog extends Model
{
    use HasFactory;


    protected $fillable = [
        'event_id', 'registration_id', 'transaction_number', 'logs', 'status'
    ];
}
