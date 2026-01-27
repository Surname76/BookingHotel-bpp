<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'special_request',
        'status',
        'note',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
