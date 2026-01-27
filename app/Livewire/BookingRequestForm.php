<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use App\Models\Room;
use App\Models\User;
use App\Notifications\NewBookingNotification;

class BookingRequestForm extends Component
{
    public Room $room;

    public $step = 'select';
    public $selectedType;
    public $guest_name;
    public $guest_email;
    public $guest_phone;
    public $check_in;
    public $check_out;
    public $special_request;

    public function mount(Room $room)
    {
        $this->room = $room;
    }

    public function chooseType($typeId)
    {
        $this->selectedType = Room::findOrFail($typeId);
        $this->step = 'benefit';
    }

    public function proceedToForm()
    {
        $this->step = 'form';
    }

    public function back()
    {
        $this->step = $this->step === 'form' ? 'benefit' : 'select';
    }

    public function submit()
    {
        $this->validate([
            'guest_name'  => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'nullable|string|max:20',
            'check_in'    => 'required|date',
            'check_out'   => 'required|date|after:check_in',
        ]);

        BookingRequest::create([
            'room_id'        => $this->selectedType->id ?? $this->room->id,
            'guest_name'     => $this->guest_name,
            'guest_email'    => $this->guest_email,
            'guest_phone'    => $this->guest_phone,
            'check_in'       => $this->check_in,
            'check_out'      => $this->check_out,
            'special_request' => $this->special_request,
            'status'         => 'pending',
        ]);

        session()->flash('message', 'Booking Anda berhasil dikirim! Tim kami akan menghubungi Anda.');
        $this->reset([
            'guest_name',
            'guest_email',
            'guest_phone',
            'check_in',
            'check_out',
            'special_request',
        ]);

        $this->step = 'select';
    }



    public function render()
    {
        return view('livewire.booking-request-form', [
            'roomTypes' => Room::where('hotel_id', $this->room->hotel_id)->get(),
        ]);
    }
}
