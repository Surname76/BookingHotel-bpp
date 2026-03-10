<?php

namespace App\Livewire;

use App\Models\BookingRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Models\Discount;
use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Notifications\NewBookingRequestNotification;
use App\Services\Xendit\XenditInvoiceService;
use App\Services\DiscountService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingRequestForm extends Component
{
    public Room $room;

    public $guest_name;
    public $guest_email;
    public $guest_phone;
    public $check_in;
    public $check_in_time;
    public $check_out;
    public $check_out_time;
    public $special_request;

    // Discount & Voucher
    public $voucherCode = '';
    public $appliedVoucher = null;
    public $voucherError = '';
    public $selectedDiscounts = [];
    public $availableDiscounts = [];
    
    public $subtotal = 0;
    public $totalDiscount = 0;
    public $finalTotal = 0;
    public $appliedDiscountsData = [];

    protected $listeners = ['discountUpdated' => 'handleDiscountUpdate'];

    public function mount(Room $room)
    {
        $this->room = $room;

        if (Auth::check()) {
            $this->guest_name = Auth::user()->name;
            $this->guest_email = Auth::user()->email;
        }

        $this->check_in_time = '14:00';
        $this->check_out_time = '12:00';
    }

    public function updated($propertyName)
    {
        // Recalculate when dates change
        if (in_array($propertyName, ['check_in', 'check_out'])) {
            $this->loadAvailableDiscounts();
            $this->calculateTotal();
        }
    }

    public function loadAvailableDiscounts()
    {
        if (!$this->check_in || !$this->check_out) {
            $this->availableDiscounts = collect();
            return;
        }

        $discountService = app(DiscountService::class);
        
        $this->availableDiscounts = $discountService->getApplicableDiscounts(
            $this->room->hotel_id,
            $this->room->id,
            $this->check_in,
            $this->check_out,
            Auth::id()
        );
    }

    public function toggleDiscount($discountId)
    {
        if (in_array($discountId, $this->selectedDiscounts)) {
            $this->selectedDiscounts = array_diff($this->selectedDiscounts, [$discountId]);
        } else {
            $this->selectedDiscounts[] = $discountId;
        }
        
        $this->calculateTotal();
    }

    public function applyVoucher()
    {
        $this->voucherError = '';
        
        if (empty($this->voucherCode)) {
            $this->voucherError = 'Masukkan kode voucher';
            return;
        }

        if (!$this->check_in || !$this->check_out) {
            $this->voucherError = 'Pilih tanggal check-in dan check-out terlebih dahulu';
            return;
        }

        $discountService = app(DiscountService::class);
        
        $validation = $discountService->validateVoucher(
            strtoupper($this->voucherCode),
            $this->room->hotel_id,
            $this->room->id,
            $this->check_in,
            $this->check_out,
            Auth::id()
        );

        if (!$validation['valid']) {
            $this->voucherError = $validation['message'];
            return;
        }

        $this->appliedVoucher = $validation['voucher'];
        $this->calculateTotal();
        
        session()->flash('voucher_success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        $this->appliedVoucher = null;
        $this->voucherCode = '';
        $this->voucherError = '';
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        if (!$this->check_in || !$this->check_out) {
            $this->subtotal = 0;
            $this->totalDiscount = 0;
            $this->finalTotal = 0;
            $this->appliedDiscountsData = [];
            return;
        }

        $discountService = app(DiscountService::class);
        
        $result = $discountService->calculateTotal(
            $this->room->hotel_id,
            $this->room->id,
            $this->check_in,
            $this->check_out,
            $this->selectedDiscounts,
            $this->appliedVoucher ? $this->appliedVoucher->code : null,
            Auth::id()
        );

        $this->subtotal = $result['subtotal'];
        $this->totalDiscount = $result['discount_amount'];
        $this->finalTotal = $result['total'];
        $this->appliedDiscountsData = $result['applied_discounts'];
    }

    public function handleDiscountUpdate($data)
    {
        $this->subtotal = $data['subtotal'];
        $this->totalDiscount = $data['discount_amount'];
        $this->finalTotal = $data['total'];
        $this->appliedDiscountsData = $data['applied_discounts'];
    }

    public function submit()
    {
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $secretKey = (string) config('xendit.secret_key');
        if ($secretKey === '') {
            session()->flash('message', 'Payment belum aktif. Silakan hubungi admin.');
            $this->addError('guest_email', 'Payment gateway (Xendit) belum dikonfigurasi.');
            return;
        }

        $this->validate([
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'nullable|string|max:20',
            'check_in'    => 'required|date',
            'check_out'   => 'required|date|after:check_in',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
        ]);

        $room = $this->room;

        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);
        $totalNights = max(1, $checkIn->diffInDays($checkOut));

        $pricePerNight = (float) $room->price_per_night;
        $subtotal = $totalNights * $pricePerNight;

        // Calculate final amount with discounts
        $discountService = app(DiscountService::class);
        $calculation = $discountService->calculateTotal(
            $this->room->hotel_id,
            $this->room->id,
            $this->check_in,
            $this->check_out,
            $this->selectedDiscounts,
            $this->appliedVoucher ? $this->appliedVoucher->code : null,
            Auth::id()
        );

        $amount = $calculation['total'];
        $discountAmount = $calculation['discount_amount'];

        $overlapExists = Booking::query()
            ->where('room_id', $room->id)
            ->where('status', 'confirmed')
            ->whereDate('check_in', '<', $checkOut)
            ->whereDate('check_out', '>', $checkIn)
            ->exists();

        if ($overlapExists) {
            $this->addError('check_in', 'Maaf, tanggal yang dipilih sudah tidak tersedia.');
            return;
        }

        $invoiceService = app(XenditInvoiceService::class);

        // Get discount and voucher IDs
        $discountId = !empty($this->selectedDiscounts) ? $this->selectedDiscounts[0] : null;
        $voucherId = $this->appliedVoucher ? $this->appliedVoucher->id : null;

        $bookingRequest = BookingRequest::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
            'check_in' => $checkIn->toDateString(),
            'check_in_time' => $this->check_in_time,
            'check_out' => $checkOut->toDateString(),
            'check_out_time' => $this->check_out_time,
            'special_request' => $this->special_request,
            'status' => 'pending',
        ]);

        $externalId = 'booking-'.$bookingRequest->id.'-'.Str::ulid()->toBase32();

        $payment = Payment::create([
            'booking_request_id' => $bookingRequest->id,
            'user_id' => Auth::id(),
            'provider' => 'xendit',
            'external_id' => $externalId,
            'currency' => 'IDR',
            'amount' => $amount,
            'status' => 'pending',
            'expires_at' => now()->addSeconds((int) config('xendit.invoice.duration_seconds')),
            'metadata' => [
                'room_id' => $room->id,
                'total_nights' => $totalNights,
                'price_per_night' => $room->price_per_night,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_id' => $discountId,
                'voucher_id' => $voucherId,
                'applied_discounts' => $calculation['applied_discounts'],
            ],
        ]);

        $successUrl = (string) (config('xendit.redirect.success_url') ?: route('payments.return', ['status' => 'success']));
        $failureUrl = (string) (config('xendit.redirect.failure_url') ?: route('payments.return', ['status' => 'failure']));

        // Build description with discount info
        $description = 'Booking '.$bookingRequest->id.' - '.$room->name;
        if ($discountAmount > 0) {
            $description .= ' (Diskon: Rp '.number_format($discountAmount, 0, ',', '.').')';
        }

        $payload = [
            'external_id' => $externalId,
            'amount' => (int) round($amount),
            'payer_email' => $this->guest_email,
            'description' => $description,
            'invoice_duration' => (int) config('xendit.invoice.duration_seconds'),
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $failureUrl,
        ];

        try {
            $invoice = $invoiceService->createInvoice($payload);
        } catch (\Throwable $e) {
            report($e);
            $payment->update(['status' => 'invoice_failed']);
            session()->flash('message', 'Invoice gagal dibuat. Silakan coba bayar lagi dari Riwayat Pemesanan.');
            $this->redirectRoute('bookings.history', navigate: true);
            return;
        }

        $payment->update([
            'provider_reference' => $invoice['id'] ?? null,
            'invoice_url' => $invoice['invoice_url'] ?? null,
            'metadata' => array_merge($payment->metadata ?? [], [
                'xendit' => $invoice,
            ]),
        ]);

        // Mark voucher as used (will be recorded in UserVoucher when payment is confirmed)
        if ($voucherId && Auth::id()) {
            UserVoucher::create([
                'user_id' => Auth::id(),
                'voucher_id' => $voucherId,
                'used_at' => null, // Will be updated when payment confirmed
            ]);
        }

        User::query()
            ->where('is_admin', true)
            ->get()
            ->each(fn (User $admin) => $admin->notify(new NewBookingRequestNotification($bookingRequest)));

        if (! $payment->invoice_url) {
            session()->flash('message', 'Invoice belum tersedia. Silakan cek riwayat pemesanan.');
            $this->redirectRoute('bookings.history', navigate: true);
            return;
        }

        $this->redirect($payment->invoice_url, navigate: false);
    }

    public function render()
    {
        $totalNights = null;
        $estimatedAmount = null;

        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::createFromFormat('Y-m-d', (string) $this->check_in) ?: null;
            $checkOut = Carbon::createFromFormat('Y-m-d', (string) $this->check_out) ?: null;

            if ($checkIn && $checkOut && $checkOut->greaterThan($checkIn)) {
                $totalNights = max(1, $checkIn->diffInDays($checkOut));
                $estimatedAmount = $totalNights * (float) $this->room->price_per_night;
                
                // Use calculated total if discounts applied
                if ($this->finalTotal > 0) {
                    $estimatedAmount = $this->finalTotal;
                }
            }
        }

        return view('livewire.booking-request-form', compact('totalNights', 'estimatedAmount'));
    }
}