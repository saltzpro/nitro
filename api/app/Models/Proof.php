<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id', 'name', 'reference_number', 'amount', 'proof_image'
    ];
}
