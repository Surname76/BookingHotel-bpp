<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'discount_type',
        'discount_value',
        'min_nights',
        'min_amount',
        'applicable_room_types',
        'applicable_days',
        'applicable_hotel_ids',
        'applicable_room_ids',
        'valid_from',
        'valid_until',
        'max_usage',
        'usage_count',
        'max_usage_per_user',
        'is_active',
        'is_stackable',
    ];

    protected $casts = [
        'applicable_room_types' => 'array',
        'applicable_days' => 'array',
        'applicable_hotel_ids' => 'array',
        'applicable_room_ids' => 'array',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
        'discount_value' => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Check if discount is valid
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    // Check if applicable to booking
    public function isApplicable($hotelId, $roomId, $roomType, $checkIn, $nights, $amount, $userId = null): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check hotel
        if ($this->applicable_hotel_ids && !in_array($hotelId, $this->applicable_hotel_ids)) {
            return false;
        }

        // Check room
        if ($this->applicable_room_ids && !in_array($roomId, $this->applicable_room_ids)) {
            return false;
        }

        // Check room type (single/twin)
        if ($this->applicable_room_types && !in_array($roomType, $this->applicable_room_types)) {
            return false;
        }

        // Check minimum nights
        if ($this->min_nights && $nights < $this->min_nights) {
            return false;
        }

        // Check minimum amount
        if ($this->min_amount && $amount < $this->min_amount) {
            return false;
        }

        // Check weekday
        if ($this->type === 'weekday' && $this->applicable_days) {
            $dayOfWeek = Carbon::parse($checkIn)->dayOfWeek;
            if (!in_array($dayOfWeek, $this->applicable_days)) {
                return false;
            }
        }

        // Check usage per user
        if ($userId && $this->max_usage_per_user) {
            $userUsage = Booking::where('user_id', $userId)
                ->where('discount_id', $this->id)
                ->count();
            
            if ($userUsage >= $this->max_usage_per_user) {
                return false;
            }
        }

        return true;
    }

    // Calculate discount amount
    public function calculateDiscount($amount): float
    {
        if ($this->discount_type === 'percentage') {
            return ($amount * $this->discount_value) / 100;
        }

        return min($this->discount_value, $amount);
    }
}