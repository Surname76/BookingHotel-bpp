<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_request_id',
        'payment_id',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_in_time',
        'check_out',
        'check_out_time',
        'price_per_night',
        'total_nights',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingRequest()
    {
        return $this->belongsTo(BookingRequest::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /* RELATION */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /* RELATION INDIRECT */
    public function hotel()
    {
        return $this->room?->hotel;
    }
}
