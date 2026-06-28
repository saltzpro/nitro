<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'source', 'account_number', 'account_name'
    ];
}
