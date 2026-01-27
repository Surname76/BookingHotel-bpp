<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;

class RoomList extends Component
{
    public $rooms;

    /**
     * Load available rooms saat component mount
     */
    public function mount($rooms = null)
    {
        $this->rooms = $rooms ?? Room::where('is_available', true)->get();
    }

    public function render()
    {
        return view('livewire.room-list');
    }
}
