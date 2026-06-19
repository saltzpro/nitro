<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'name',
        'phone_number',
        'payment_from',
        'reference_number',
        'amount',
        'proof_path'
    ];
}
