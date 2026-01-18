<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\BookingRequest;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'total'     => BookingRequest::count(),
            'pending'   => BookingRequest::where('status', 'pending')->count(),
            'confirmed' => BookingRequest::where('status', 'confirmed')->count(),
            'rejected'  => BookingRequest::where('status', 'rejected')->count(),
            'title'     => 'Admin Dashboard',
        ]);
    }
}
