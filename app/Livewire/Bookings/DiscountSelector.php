<?php

namespace App\Livewire\Bookings;

use App\Models\Discount;
use App\Models\Voucher;
use App\Services\DiscountService;
use Livewire\Component;

class DiscountSelector extends Component
{
    public $hotelId;
    public $roomId;
    public $checkIn;
    public $checkOut;
    public $subtotal;

    public $voucherCode = '';
    public $appliedVoucher = null;
    public $voucherError = '';
    
    public $selectedDiscounts = [];
    public $availableDiscounts = [];
    
    public $totalDiscount = 0;
    public $finalTotal = 0;

    protected $discountService;

    public function mount($hotelId, $roomId, $checkIn, $checkOut, $subtotal)
    {
        $this->hotelId = $hotelId;
        $this->roomId = $roomId;
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;
        $this->subtotal = $subtotal;
        
        $this->loadAvailableDiscounts();
        $this->calculate();
    }

    public function boot(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function loadAvailableDiscounts()
    {
        $this->availableDiscounts = $this->discountService->getApplicableDiscounts(
            $this->hotelId,
            $this->roomId,
            $this->checkIn,
            $this->checkOut,
            auth()->id()
        );
    }

    public function applyVoucher()
    {
        $this->voucherError = '';
        
        if (empty($this->voucherCode)) {
            $this->voucherError = 'Masukkan kode voucher';
            return;
        }

        $validation = $this->discountService->validateVoucher(
            $this->voucherCode,
            $this->hotelId,
            $this->roomId,
            $this->checkIn,
            $this->checkOut,
            auth()->id()
        );

        if (!$validation['valid']) {
            $this->voucherError = $validation['message'];
            return;
        }

        $this->appliedVoucher = $validation['voucher'];
        $this->calculate();
        
        session()->flash('voucher_success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        $this->appliedVoucher = null;
        $this->voucherCode = '';
        $this->voucherError = '';
        $this->calculate();
    }

    public function toggleDiscount($discountId)
    {
        if (in_array($discountId, $this->selectedDiscounts)) {
            $this->selectedDiscounts = array_diff($this->selectedDiscounts, [$discountId]);
        } else {
            $this->selectedDiscounts[] = $discountId;
        }
        
        $this->calculate();
    }

    public function calculate()
    {
        $result = $this->discountService->calculateTotal(
            $this->hotelId,
            $this->roomId,
            $this->checkIn,
            $this->checkOut,
            $this->selectedDiscounts,
            $this->appliedVoucher ? $this->appliedVoucher->code : null,
            auth()->id()
        );

        $this->totalDiscount = $result['discount_amount'];
        $this->finalTotal = $result['total'];
        
        // Emit event untuk parent component
        $this->dispatch('discountUpdated', [
            'subtotal' => $result['subtotal'],
            'discount_amount' => $result['discount_amount'],
            'total' => $result['total'],
            'applied_discounts' => $result['applied_discounts']
        ]);
    }

    public function render()
    {
        return view('livewire.bookings.discount-selector');
    }
}