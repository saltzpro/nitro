<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id', 
        'name', 
        'sub_name', 
        'category_image', 
        'original_price', 
        'current_price'
    ];
    
}
