<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Hotel;
use Illuminate\Validation\Rule;
use App\Models\Room;

class HotelCrud extends Component
{
    public $hotels;

    // Modal states
    public $showHotelModal = false;
    public $showRoomModal = false;

    // form state
    public $hotelId = null;
    public $name;
    public $district;
    public $map_link;
    public $image_url;
    public $price_per_night;
    public $description;
    public $is_available = true;
    public $isEdit = false;
    public $selectedHotelId = null;
    public $rooms = [];
    // room form
    public $roomId = null;
    public $room_name;
    public $room_description;
    public $room_capacity;
    public $room_price_per_night;
    public $room_benefits = '[]'; // Changed to string for JSON input
    public $room_is_available = true;

    public $isEditingRoom = false;

    public $districts = [
        'Balikpapan Kota',
        'Balikpapan Timur',
        'Balikpapan Barat',
        'Balikpapan Selatan',
        'Balikpapan Utara',
        'Balikpapan Tengah',
    ];

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'map_link' => ['nullable', 'url'],
            'image_url' => ['nullable', 'url'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_available' => ['boolean'],
        ];
    }

    public function mount()
    {
        $this->loadHotels();
    }

    public function loadHotels()
    {
        $this->hotels = Hotel::latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showHotelModal = true;
    }

    public function store()
    {
        $this->validate();

        Hotel::create($this->formData());

        $this->loadHotels();
        $this->resetForm();
        $this->showHotelModal = false;

        // Flash message (optional)
        session()->flash('message', 'Hotel berhasil ditambahkan!');
    }

    public function edit(int $id)
    {
        $hotel = Hotel::findOrFail($id);

        $this->hotelId = $hotel->id;
        $this->name = $hotel->name;
        $this->district = $hotel->district;
        $this->map_link = $hotel->map_link;
        $this->image_url = $hotel->image_url;
        $this->price_per_night = $hotel->price_per_night;
        $this->description = $hotel->description;
        $this->is_available = $hotel->is_available;

        $this->isEdit = true;
        $this->showHotelModal = true;
    }

    public function update()
    {
        $this->validate();

        Hotel::where('id', $this->hotelId)
            ->update($this->formData());

        $this->loadHotels();
        $this->resetForm();
        $this->showHotelModal = false;

        session()->flash('message', 'Hotel berhasil diupdate!');
    }

    public function delete(int $id)
    {
        Hotel::where('id', $id)->delete();

        $this->loadHotels();

        session()->flash('message', 'Hotel berhasil dihapus!');
    }

    public function closeHotelModal()
    {
        $this->showHotelModal = false;
        $this->resetForm();
    }

    protected function formData(): array
    {
        return [
            'name' => $this->name,
            'district' => $this->district,
            'map_link' => $this->map_link,
            'image_url' => $this->image_url,
            'price_per_night' => $this->price_per_night,
            'description' => $this->description,
            'is_available' => $this->is_available,
        ];
    }

    protected function resetForm()
    {
        $this->reset([
            'hotelId',
            'name',
            'district',
            'map_link',
            'image_url',
            'price_per_night',
            'description',
            'is_available',
            'isEdit',
        ]);

        $this->is_available = true;
    }

    // CRUD Kamar

    public function selectHotel(int $hotelId)
    {
        $this->selectedHotelId = $hotelId;

        $this->rooms = Room::where('hotel_id', $hotelId)
            ->latest()
            ->get();

        $this->resetRoomForm();
    }

    public function closeRoomModal()
    {
        $this->selectedHotelId = null;
        $this->rooms = [];
        $this->resetRoomForm();
    }

    protected function roomRules(): array
    {
        return [
            'room_name' => ['required', 'string', 'max:255'],
            'room_description' => ['nullable', 'string'],
            'room_capacity' => ['required', 'integer', 'min:1'],
            'room_price_per_night' => ['required', 'numeric', 'min:0'],
            'room_benefits' => ['nullable', 'string'], // Validate as string
            'room_is_available' => ['boolean'],
            'selectedHotelId' => ['required', 'exists:hotels,id'],
        ];
    }

    public function storeRoom()
    {
        $this->validate($this->roomRules());

        // Parse JSON benefits
        $benefits = [];
        if (!empty($this->room_benefits)) {
            try {
                $benefits = json_decode($this->room_benefits, true);
                if (!is_array($benefits)) {
                    $benefits = [];
                }
            } catch (\Exception $e) {
                $benefits = [];
            }
        }

        Room::create([
            'hotel_id' => $this->selectedHotelId,
            'name' => $this->room_name,
            'description' => $this->room_description,
            'capacity' => $this->room_capacity,
            'price_per_night' => $this->room_price_per_night,
            'benefits' => $benefits,
            'is_available' => $this->room_is_available,
        ]);

        $this->reloadRooms();
        $this->resetRoomForm();

        session()->flash('room_message', 'Kamar berhasil ditambahkan!');
    }

    public function editRoom(int $roomId)
    {
        $room = Room::where('hotel_id', $this->selectedHotelId)
            ->findOrFail($roomId);

        $this->roomId = $room->id;
        $this->room_name = $room->name;
        $this->room_description = $room->description;
        $this->room_capacity = $room->capacity;
        $this->room_price_per_night = $room->price_per_night;

        // Convert array to JSON string for input field
        $this->room_benefits = !empty($room->benefits)
            ? json_encode($room->benefits)
            : '[]';

        $this->room_is_available = $room->is_available;

        $this->isEditingRoom = true;
    }

    public function updateRoom()
    {
        $this->validate($this->roomRules());

        // Parse JSON benefits
        $benefits = [];
        if (!empty($this->room_benefits)) {
            try {
                $benefits = json_decode($this->room_benefits, true);
                if (!is_array($benefits)) {
                    $benefits = [];
                }
            } catch (\Exception $e) {
                $benefits = [];
            }
        }

        Room::where('id', $this->roomId)
            ->where('hotel_id', $this->selectedHotelId)
            ->update([
                'name' => $this->room_name,
                'description' => $this->room_description,
                'capacity' => $this->room_capacity,
                'price_per_night' => $this->room_price_per_night,
                'benefits' => $benefits,
                'is_available' => $this->room_is_available,
            ]);

        $this->reloadRooms();
        $this->resetRoomForm();

        session()->flash('room_message', 'Kamar berhasil diupdate!');
    }

    public function cancelRoomEdit()
    {
        $this->resetRoomForm();
    }

    public function deleteRoom(int $roomId)
    {
        Room::where('id', $roomId)
            ->where('hotel_id', $this->selectedHotelId)
            ->delete();

        $this->reloadRooms();

        session()->flash('room_message', 'Kamar berhasil dihapus!');
    }

    protected function reloadRooms()
    {
        if ($this->selectedHotelId) {
            $this->rooms = Room::where('hotel_id', $this->selectedHotelId)
                ->latest()
                ->get();
        }
    }

    protected function resetRoomForm()
    {
        $this->reset([
            'roomId',
            'room_name',
            'room_description',
            'room_capacity',
            'room_price_per_night',
            'room_benefits',
            'room_is_available',
            'isEditingRoom',
        ]);

        $this->room_benefits = '[]';
        $this->room_is_available = true;
    }

    public function render()
    {
        return view('livewire.admin.hotel-crud');
    }
}
