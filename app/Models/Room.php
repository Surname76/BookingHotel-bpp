<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'hotel_id',
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

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
