<?php

namespace App\Livewire\Rooms;

use Livewire\Component;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public Hotel $hotel;
    
    // State untuk Modal Booking
    public ?Room $selectedRoom = null;
    public $showBookingModal = false;
    
    // State untuk Modal Fasilitas
    public $showFacilitiesModal = false;

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
        if (! Auth::check()) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $this->selectedRoom = Room::findOrFail($roomId);
        $this->showBookingModal = true;
    }

    public function closeBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedRoom = null;
    }

    /**
     * Method untuk mendapatkan icon SVG berdasarkan nama fasilitas
     */
    public function getFacilityIcon($facility)
    {
        $facility = strtolower($facility);
        
        // Wifi / Internet
        if (str_contains($facility, 'wifi') || str_contains($facility, 'internet')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                    </svg>';
        }
        
        // Parkir
        if (str_contains($facility, 'parkir') || str_contains($facility, 'parking')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>';
        }
        
        // AC / Air Conditioner
        if (str_contains($facility, 'ac') || str_contains($facility, 'air conditioner') || 
            str_contains($facility, 'pendingin') || str_contains($facility, 'full ac')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>';
        }
        
        // Restaurant / Cafe / Dining
        if (str_contains($facility, 'restoran') || str_contains($facility, 'restaurant') || 
            str_contains($facility, 'cafe') || str_contains($facility, 'makan') || 
            str_contains($facility, 'dining') || str_contains($facility, 'kuliner')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>';
        }
        
        // Pool / Kolam Renang
        if (str_contains($facility, 'pool') || str_contains($facility, 'kolam') || 
            str_contains($facility, 'renang') || str_contains($facility, 'swimming')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>';
        }
        
        // Gym / Fitness
        if (str_contains($facility, 'gym') || str_contains($facility, 'fitness') || 
            str_contains($facility, 'olahraga') || str_contains($facility, 'sport')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>';
        }
        
        // Receptionist / Resepsionis 24 Jam
        if (str_contains($facility, 'resepsionis') || str_contains($facility, 'reception') || 
            str_contains($facility, '24 jam') || str_contains($facility, '24/7') || 
            str_contains($facility, '24 hours')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>';
        }
        
        // TV / Television
        if (str_contains($facility, 'tv') || str_contains($facility, 'television') || 
            str_contains($facility, 'televisi') || str_contains($facility, 'cable')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>';
        }
        
        // Laundry
        if (str_contains($facility, 'laundry') || str_contains($facility, 'cuci') || 
            str_contains($facility, 'laudry')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>';
        }
        
        // Security / Keamanan
        if (str_contains($facility, 'security') || str_contains($facility, 'keamanan') || 
            str_contains($facility, 'cctv') || str_contains($facility, 'aman')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>';
        }
        
        // Breakfast / Sarapan
        if (str_contains($facility, 'breakfast') || str_contains($facility, 'sarapan') || 
            str_contains($facility, 'buffet')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>';
        }
        
        // Spa / Massage
        if (str_contains($facility, 'spa') || str_contains($facility, 'massage') || 
            str_contains($facility, 'pijat') || str_contains($facility, 'relax')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>';
        }
        
        // Meeting Room / Ruang Rapat
        if (str_contains($facility, 'meeting') || str_contains($facility, 'rapat') || 
            str_contains($facility, 'conference') || str_contains($facility, 'ballroom')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>';
        }
        
        // Elevator / Lift
        if (str_contains($facility, 'elevator') || str_contains($facility, 'lift')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>';
        }
        
        // Bar / Mini Bar
        if (str_contains($facility, 'bar') || str_contains($facility, 'minuman') || 
            str_contains($facility, 'drink')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>';
        }
        
        // Room Service
        if (str_contains($facility, 'room service') || str_contains($facility, 'layanan kamar')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>';
        }
        
        // Smoking Area
        if (str_contains($facility, 'smoking') || str_contains($facility, 'merokok')) {
            return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>';
        }
        
        // Default icon - checkmark
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>';
    }

    public function render()
    {
        return view('livewire.rooms.show', [
            'title' => $this->hotel->name . ' - BookingHotel',
        ]);
    }
}