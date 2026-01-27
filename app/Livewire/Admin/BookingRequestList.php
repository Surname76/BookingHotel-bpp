<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\BookingRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingRequestList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $selectedRequest = null;
    public $adminNote = '';

    public $search = '';

    // Reset halaman ke 1 jika user mengetik sesuatu (agar tidak error pagination)
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function select($id)
    {
        $this->selectedRequest = BookingRequest::with(['room.hotel'])
            ->findOrFail($id);

        $this->adminNote = $this->selectedRequest->note;
    }

    public function updateStatus($status)
    {
        if (!$this->selectedRequest) {
            return;
        }

        DB::transaction(function () use ($status) {

            if ($status === 'sent') {

                if ($this->selectedRequest->status !== 'sent') {

                    $checkIn  = Carbon::parse($this->selectedRequest->check_in);
                    $checkOut = Carbon::parse($this->selectedRequest->check_out);

                    $totalNights = $checkIn->diffInDays($checkOut);
                    $pricePerNight = $this->selectedRequest->room->price_per_night;
                    $totalPrice = $totalNights * $pricePerNight;

                    Booking::create([
                        'room_id'         => $this->selectedRequest->room_id,
                        'guest_name'      => $this->selectedRequest->guest_name,
                        'guest_email'     => $this->selectedRequest->guest_email,
                        'guest_phone'     => $this->selectedRequest->guest_phone,
                        'check_in'        => $checkIn,
                        'check_out'       => $checkOut,
                        'price_per_night' => $pricePerNight,
                        'total_nights'    => $totalNights,
                        'total_price'     => $totalPrice,
                        'status'          => 'confirmed',
                    ]);
                }

                $this->selectedRequest->update([
                    'status' => 'sent',
                    'note'   => $this->adminNote,
                ]);
            }

            if ($status === 'rejected') {
                $this->selectedRequest->delete();
            }
        });

        session()->flash('message', 'Status booking berhasil diproses.');

        $this->reset(['selectedRequest', 'adminNote']);
    }

    public function closeModal()
    {
        // 1. Tutup Modal
        $this->selectedRequest = null;

        // 2. Reset input form (Penting agar catatan tidak tertinggal)
        $this->adminNote = '';

        // 3. Hapus pesan error validasi jika ada
        $this->resetErrorBag();
    }

public function render()
{
    // Query dengan Filter Pencarian
    $requests = BookingRequest::with(['room.hotel'])
        ->when($this->search, function ($query) {
            $query->where('guest_name', 'like', '%' . $this->search . '%')
                  ->orWhere('guest_email', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Sesuaikan jumlah per halaman

    return view('livewire.admin.booking-request-list', [
        'requests' => $requests
    ]);
}
}
