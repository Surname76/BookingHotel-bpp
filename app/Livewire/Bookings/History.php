<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use App\Models\BookingRequest;
use App\Models\Payment;
use App\Services\Xendit\XenditInvoiceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Riwayat Pemesanan')]
#[Layout('layouts.app')]
class History extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function pay(int $bookingRequestId): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $secretKey = (string) config('xendit.secret_key');
        if ($secretKey === '') {
            session()->flash('message', 'Payment belum aktif. Silakan hubungi admin.');
            return;
        }

        $bookingRequest = BookingRequest::query()
            ->with(['room.hotel'])
            ->whereKey($bookingRequestId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($bookingRequest->cancelled_at) {
            session()->flash('message', 'Request ini sudah dibatalkan.');
            return;
        }

        if ($bookingRequest->status === 'confirmed') {
            session()->flash('message', 'Request ini sudah terkonfirmasi.');
            return;
        }

        $room = $bookingRequest->room;
        $checkIn = Carbon::parse($bookingRequest->check_in);
        $checkOut = Carbon::parse($bookingRequest->check_out);
        $totalNights = max(1, $checkIn->diffInDays($checkOut));

        $pricePerNight = (float) $room->price_per_night;
        $amount = $totalNights * $pricePerNight;

        $externalId = 'booking-'.$bookingRequest->id.'-'.Str::ulid()->toBase32();

        $payment = Payment::create([
            'booking_request_id' => $bookingRequest->id,
            'user_id' => $user->id,
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
                'retry' => true,
            ],
        ]);

        $successUrl = (string) (config('xendit.redirect.success_url') ?: route('payments.return', ['status' => 'success']));
        $failureUrl = (string) (config('xendit.redirect.failure_url') ?: route('payments.return', ['status' => 'failure']));

        $payload = [
            'external_id' => $externalId,
            'amount' => (int) round($amount),
            'payer_email' => $bookingRequest->guest_email,
            'description' => 'Booking '.$bookingRequest->id.' - '.$room->name,
            'invoice_duration' => (int) config('xendit.invoice.duration_seconds'),
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $failureUrl,
        ];

        try {
            $invoice = app(XenditInvoiceService::class)->createInvoice($payload);
        } catch (\Throwable $e) {
            report($e);
            $payment->update(['status' => 'invoice_failed']);
            session()->flash('message', 'Invoice gagal dibuat. Silakan coba lagi.');
            return;
        }

        $payment->update([
            'provider_reference' => $invoice['id'] ?? null,
            'invoice_url' => $invoice['invoice_url'] ?? null,
            'metadata' => array_merge($payment->metadata ?? [], ['xendit' => $invoice]),
        ]);

        if (! $payment->invoice_url) {
            session()->flash('message', 'Invoice belum tersedia.');
            return;
        }

        $this->redirect($payment->invoice_url, navigate: false);
    }

    public function cancelRequest(int $bookingRequestId): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $request = BookingRequest::query()
            ->whereKey($bookingRequestId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->whereNull('user_id')
                            ->where('guest_email', $user->email);
                    });
            })
            ->firstOrFail();

        if ($request->cancelled_at) {
            session()->flash('message', 'Request ini sudah dibatalkan.');
            return;
        }

        if ($request->status !== 'pending') {
            session()->flash('message', 'Request ini sudah diproses, tidak bisa dibatalkan.');
            return;
        }

        $request->update([
            'cancelled_at' => now(),
        ]);

        session()->flash('message', 'Booking request berhasil dibatalkan.');
    }

    public function render()
    {
        $user = Auth::user();

        $bookingRequests = BookingRequest::query()
            ->with(['room.hotel', 'latestPayment'])
            ->when($user, function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->whereNull('user_id')
                            ->where('guest_email', $user->email);
                    });
            })
            ->latest()
            ->paginate(10, pageName: 'requestsPage');

        $bookings = Booking::query()
            ->with(['room.hotel', 'payment'])
            ->when($user, function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->whereNull('user_id')
                            ->where('guest_email', $user->email);
                    });
            })
            ->latest()
            ->paginate(10, pageName: 'bookingsPage');

        return view('livewire.bookings.history', [
            'bookingRequests' => $bookingRequests,
            'bookings' => $bookings,
        ]);
    }
}
