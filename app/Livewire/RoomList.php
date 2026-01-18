<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class RoomList extends Component
{
    public $rooms;
    public $selectedRoom;

    public $guest_name;
    public $guest_email;
    public $guest_phone;
    public $check_in;
    public $check_out;

    public $showModal = false;

    /**
     * Load available rooms saat component mount
     */
    public function mount()
    {
        $this->rooms = Room::where('is_available', true)->get();
    }

    /**
     * Buka modal booking untuk kamar tertentu
     */
    public function openBookingModal($roomId)
    {
        $this->resetInput(); // reset input sebelumnya
        $this->selectedRoom = Room::find($roomId);
        $this->showModal = true;
    }

    /**
     * Reset semua input form
     */
    public function resetInput()
    {
        $this->guest_name = '';
        $this->guest_email = '';
        $this->guest_phone = '';
        $this->check_in = '';
        $this->check_out = '';
    }

    /**
     * Simpan booking
     */
    public function book()
    {
        $this->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkInDate = Carbon::parse($this->check_in);
        $checkOutDate = Carbon::parse($this->check_out);
        $totalNights = $checkOutDate->diffInDays($checkInDate);

        $totalPrice = $totalNights * $this->selectedRoom->price_per_night;

        Booking::create([
            'room_id' => $this->selectedRoom->id,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'price_per_night' => $this->selectedRoom->price_per_night,
            'total_nights' => $totalNights,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // tutup modal
        $this->showModal = false;

        // flash message
        session()->flash('message', "Booking untuk {$this->selectedRoom->name} berhasil!");

        // reload available rooms
        $this->rooms = Room::where('is_available', true)->get();
    }

    public function render()
    {
        return view('livewire.room-list');
    }
}
