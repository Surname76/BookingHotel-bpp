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

    public ?int $editingRequestId = null;
    public string $editGuestName = '';
    public string $editGuestPhone = '';
    public string $editCheckIn = '';
    public string $editCheckInTime = '14:00';
    public string $editCheckOut = '';
    public string $editCheckOutTime = '12:00';
    public string $editSpecialRequest = '';

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

public function startEdit(int $bookingRequestId): void
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

        if ($request->cancelled_at || in_array($request->status, ['confirmed', 'rejected'], true)) {
            session()->flash('message', 'Request ini sudah diproses, tidak bisa diubah.');
            return;
        }

        $this->editingRequestId = $request->id;
        $this->editGuestName = (string) $request->guest_name;
        $this->editGuestPhone = (string) ($request->guest_phone ?? '');
        $this->editCheckIn = $request->check_in?->toDateString() ?? '';
        $this->editCheckInTime = (string) ($request->check_in_time ?? '14:00');
        $this->editCheckOut = $request->check_out?->toDateString() ?? '';
        $this->editCheckOutTime = (string) ($request->check_out_time ?? '12:00');
        $this->editSpecialRequest = (string) ($request->special_request ?? '');
    }

    public function cancelEdit(): void
    {
        $this->resetEditForm();
    }

    public function saveEdit(): void
    {
        $user = Auth::user();
        if (! $user) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        if (! $this->editingRequestId) {
            session()->flash('message', 'Pilih request yang ingin diubah terlebih dahulu.');
            return;
        }

        $request = BookingRequest::query()
            ->whereKey($this->editingRequestId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q) use ($user) {
                        $q->whereNull('user_id')
                            ->where('guest_email', $user->email);
                    });
            })
            ->firstOrFail();

        if ($request->cancelled_at || in_array($request->status, ['confirmed', 'rejected'], true)) {
            $this->resetEditForm();
            session()->flash('message', 'Request ini sudah diproses, tidak bisa diubah.');
            return;
        }

        $validated = $this->validate([
            'editGuestName' => 'required|string|max:255',
            'editGuestPhone' => 'nullable|string|max:20',
            'editCheckIn' => 'required|date',
            'editCheckOut' => 'required|date|after:editCheckIn',
            'editCheckInTime' => 'nullable|date_format:H:i',
            'editCheckOutTime' => 'nullable|date_format:H:i',
            'editSpecialRequest' => 'nullable|string|max:1000',
        ]);

        $checkIn = Carbon::parse($validated['editCheckIn']);
        $checkOut = Carbon::parse($validated['editCheckOut']);

        $overlapExists = Booking::query()
            ->where('room_id', $request->room_id)
            ->where('status', 'confirmed')
            ->whereDate('check_in', '<', $checkOut)
            ->whereDate('check_out', '>', $checkIn)
            ->exists();

        if ($overlapExists) {
            $this->addError('editCheckIn', 'Maaf, tanggal yang dipilih sudah tidak tersedia.');
            return;
        }

        $request->update([
            'guest_name' => $validated['editGuestName'],
            'guest_phone' => $validated['editGuestPhone'] ?: null,
            'check_in' => $checkIn->toDateString(),
            'check_in_time' => $validated['editCheckInTime'] ?: null,
            'check_out' => $checkOut->toDateString(),
            'check_out_time' => $validated['editCheckOutTime'] ?: null,
            'special_request' => $validated['editSpecialRequest'] ?: null,
        ]);

        $this->resetEditForm();
        session()->flash('message', 'Booking request berhasil diperbarui.');
    }

    private function resetEditForm(): void
    {
        $this->resetValidation();
        $this->editingRequestId = null;
        $this->editGuestName = '';
        $this->editGuestPhone = '';
        $this->editCheckIn = '';
        $this->editCheckInTime = '14:00';
        $this->editCheckOut = '';
        $this->editCheckOutTime = '12:00';
        $this->editSpecialRequest = '';
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
    }}