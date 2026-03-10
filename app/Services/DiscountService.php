<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\Voucher;
use App\Models\Room;
use Carbon\Carbon;

class DiscountService
{
    public function getApplicableDiscounts($hotelId, $roomId, $checkIn, $checkOut, $userId = null)
    {
        $room = Room::find($roomId);
        if (!$room) {
            return collect();
        }

        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        $subtotal = $room->price_per_night * $nights;
        
        // Detect room type from name
        $roomType = $this->detectRoomType($room->name);

        $discounts = Discount::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->get()
            ->filter(function ($discount) use ($hotelId, $roomId, $roomType, $checkIn, $nights, $subtotal, $userId) {
                return $discount->isApplicable($hotelId, $roomId, $roomType, $checkIn, $nights, $subtotal, $userId);
            });

        return $discounts;
    }

    public function validateVoucher($code, $hotelId, $roomId, $checkIn, $checkOut, $userId)
    {
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return ['valid' => false, 'message' => 'Kode voucher tidak ditemukan'];
        }

        $room = Room::find($roomId);
        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        $subtotal = $room->price_per_night * $nights;

        if (!$voucher->isApplicable($hotelId, $roomId, $nights, $subtotal, $userId)) {
            return ['valid' => false, 'message' => 'Voucher tidak dapat digunakan untuk booking ini'];
        }

        $discountAmount = $voucher->calculateDiscount($subtotal);

        return [
            'valid' => true,
            'voucher' => $voucher,
            'discount_amount' => $discountAmount,
        ];
    }

    public function calculateTotal($hotelId, $roomId, $checkIn, $checkOut, $discountIds = [], $voucherCode = null, $userId = null)
    {
        $room = Room::find($roomId);
        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        $subtotal = $room->price_per_night * $nights;

        $totalDiscount = 0;
        $appliedDiscounts = [];

        // Apply automatic discounts
        foreach ($discountIds as $discountId) {
            $discount = Discount::find($discountId);
            if ($discount && $discount->isValid()) {
                $discountAmount = $discount->calculateDiscount($subtotal - $totalDiscount);
                $totalDiscount += $discountAmount;
                
                $appliedDiscounts[] = [
                    'type' => 'discount',
                    'id' => $discount->id,
                    'name' => $discount->name,
                    'amount' => $discountAmount,
                ];
            }
        }

        // Apply voucher
        if ($voucherCode) {
            $voucherValidation = $this->validateVoucher($voucherCode, $hotelId, $roomId, $checkIn, $checkOut, $userId);
            
            if ($voucherValidation['valid']) {
                $voucherDiscount = $voucherValidation['discount_amount'];
                $totalDiscount += $voucherDiscount;
                
                $appliedDiscounts[] = [
                    'type' => 'voucher',
                    'id' => $voucherValidation['voucher']->id,
                    'code' => $voucherCode,
                    'name' => $voucherValidation['voucher']->name,
                    'amount' => $voucherDiscount,
                ];
            }
        }

        $total = max(0, $subtotal - $totalDiscount);

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $totalDiscount,
            'total' => $total,
            'applied_discounts' => $appliedDiscounts,
            'nights' => $nights,
        ];
    }

    private function detectRoomType($roomName)
    {
        $roomName = strtolower($roomName);
        
        if (str_contains($roomName, 'twin')) {
            return 'twin';
        }
        
        if (str_contains($roomName, 'single')) {
            return 'single';
        }
        
        if (str_contains($roomName, 'double')) {
            return 'double';
        }
        
        return 'standard';
    }
}