<?php

namespace App\Livewire\Rooms;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Room;

#[Layout('layouts.app')]
class Show extends Component
{
    public Room $room;

    public function mount($id)
    {
        $this->room = Room::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.rooms.show', [
            'title' => $this->room->name . ' - BookingHotel',
        ]);
    }
}
