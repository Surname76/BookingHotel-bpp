<?php

namespace App\Livewire\Rooms;

use Livewire\Component;
use App\Models\Hotel;
use App\Models\Room;

class Show extends Component
{
    public Hotel $hotel;
    
    // State untuk Modal Booking
    public ?Room $selectedRoom = null;
    public $showBookingModal = false;

    public function mount(Hotel $hotel)
    {
        // Eager load rooms agar query efisien
        $this->hotel = $hotel->load(['rooms' => function($query) {
            $query->where('is_available', true);
        }]);
    }

    // Method untuk membuka modal booking spesifik kamar
    public function openBookingModal($roomId)
    {
        $this->selectedRoom = Room::findOrFail($roomId);
        $this->showBookingModal = true;
    }

    public function closeBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedRoom = null;
    }

    public function render()
    {
        return view('livewire.rooms.show', [
            'title' => $this->hotel->name . ' - BookingHotel',
        ]);
    }
}