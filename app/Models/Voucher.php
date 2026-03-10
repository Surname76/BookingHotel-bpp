<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_purchase',
        'min_nights',
        'applicable_hotel_ids',
        'applicable_room_ids',
        'valid_from',
        'valid_until',
        'total_quantity',
        'used_quantity',
        'max_usage_per_user',
        'voucher_type',
        'is_active',
    ];

    protected $casts = [
        'applicable_hotel_ids' => 'array',
        'applicable_room_ids' => 'array',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
    ];

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        if ($this->total_quantity && $this->used_quantity >= $this->total_quantity) {
            return false;
        }

        return true;
    }

    public function isApplicable($hotelId, $roomId, $nights, $amount, $userId): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check minimum purchase
        if ($this->min_purchase && $amount < $this->min_purchase) {
            return false;
        }

        // Check minimum nights
        if ($this->min_nights && $nights < $this->min_nights) {
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

        // Check user usage
        if ($userId) {
            $userUsage = UserVoucher::where('user_id', $userId)
                ->where('voucher_id', $this->id)
                ->whereNotNull('used_at')
                ->count();

            if ($userUsage >= $this->max_usage_per_user) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($amount): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($amount * $this->discount_value) / 100;
            
            if ($this->max_discount_amount) {
                return min($discount, $this->max_discount_amount);
            }
            
            return $discount;
        }

        return min($this->discount_value, $amount);
    }
}