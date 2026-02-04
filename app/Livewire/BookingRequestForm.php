<?php

namespace App\Livewire;

use App\Models\BookingRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use App\Notifications\NewBookingRequestNotification;
use App\Services\Xendit\XenditInvoiceService;
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
        $amount = $totalNights * $pricePerNight;

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
            ],
        ]);

        $successUrl = (string) (config('xendit.redirect.success_url') ?: route('payments.return', ['status' => 'success']));
        $failureUrl = (string) (config('xendit.redirect.failure_url') ?: route('payments.return', ['status' => 'failure']));

        $payload = [
            'external_id' => $externalId,
            'amount' => (int) round($amount),
            'payer_email' => $this->guest_email,
            'description' => 'Booking '.$bookingRequest->id.' - '.$room->name,
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
            }
        }

        return view('livewire.booking-request-form', compact('totalNights', 'estimatedAmount'));
    }
}
