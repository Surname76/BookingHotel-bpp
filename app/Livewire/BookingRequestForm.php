<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Notifications\NewBookingNotification;

class BookingRequestForm extends Component
{
    public Room $room;

    public $step = 'select';
    public $selectedType;

    public $room_type_id;
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
        $this->selectedType = RoomType::findOrFail($typeId);
        $this->room_type_id = $typeId;
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
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name'   => 'required|string|max:255',
            'guest_email'  => 'required|email',
            'check_in'     => 'required|date|after_or_equal:today',
            'check_out'    => 'required|date|after:check_in',
        ]);

        $booking = BookingRequest::create([
            'room_id'         => $this->room->id,
            'room_type_id'    => $this->room_type_id,
            'guest_name'      => $this->guest_name,
            'guest_email'     => $this->guest_email,
            'guest_phone'     => $this->guest_phone,
            'check_in'        => $this->check_in,
            'check_out'       => $this->check_out,
            'special_request' => $this->special_request,
            'status'          => 'pending',
        ]);

        User::where('is_admin', true)
            ->each(fn ($admin) => $admin->notify(
                new NewBookingNotification($booking)
            ));

        session()->flash(
            'message',
            'Permintaan booking Anda telah dikirim ke pihak hotel.'
        );

        $this->reset([
            'step',
            'selectedType',
            'room_type_id',
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
            'roomTypes' => RoomType::where('room_id', $this->room->id)->get(),
        ]);
    }
}
