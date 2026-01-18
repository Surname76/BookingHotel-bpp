<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\BookingRequest;

#[Layout('layouts.app')]
class BookingRequestList extends Component
{
    public function render()
    {
        return view('livewire.admin.booking-request-list', [
            'requests' => BookingRequest::latest()->get(),
            'title' => 'Admin – Booking Requests',
        ]);
    }
}
