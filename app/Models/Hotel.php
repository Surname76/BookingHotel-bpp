<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'name',
        'district',
        'map_link',
        'image_url',
        'price_per_night',
        'description',
        'about_property',
        'general_facilities',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'general_facilities' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
