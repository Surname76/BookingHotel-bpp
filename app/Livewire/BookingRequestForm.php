<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use App\Models\Room;
use App\Models\RoomType;

class BookingRequestForm extends Component
{
    public Room $room;

    public $step = 'select'; // select | benefit | form
    public $selectedType;

    public $room_type_id;
    public $guest_name;
    public $guest_email;
    public $guest_phone;
    public $check_in;
    public $check_out;
    public $special_request;

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
        if ($this->step === 'form') {
            $this->step = 'benefit';
        } else {
            $this->step = 'select';
        }
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

        BookingRequest::create([
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

        session()->flash(
            'message',
            'Permintaan booking Anda telah dikirim ke pihak hotel. Kami akan menghubungi Anda setelah mendapat konfirmasi.'
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
