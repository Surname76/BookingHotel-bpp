<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'price_per_night',
        'total_nights',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    /* RELATION */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /* RELATION INDIRECT */
    public function hotel()
    {
        return $this->room->hotel();
    }
}
