<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'room_type_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'special_request',
        'status',
        'note',
    ];

    /**
     * RELATION: booking milik hotel (sementara masih room)
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * RELATION: booking milik room type
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
