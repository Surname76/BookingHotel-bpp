<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'description',
        'capacity',
        'price_per_night',
        'benefits',
        'is_available',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_available' => 'boolean',
    ];
}
