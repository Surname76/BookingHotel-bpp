<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\BookingRequest;

#[Layout('layouts.app')]
class BookingRequestList extends Component
{
    public $selectedRequest = null;
    public $adminNote = '';

    public function select($id)
    {
        $this->selectedRequest = BookingRequest::with(['room', 'roomType'])
            ->findOrFail($id);

        $this->adminNote = $this->selectedRequest->note;
    }

    public function updateStatus($status)
    {
        if (!$this->selectedRequest) {
            return;
        }

        $this->selectedRequest->update([
            'status' => $status,
            'note'   => $this->adminNote,
        ]);

        session()->flash('message', 'Status booking berhasil diperbarui.');

        $this->reset(['selectedRequest', 'adminNote']);
    }

    public function render()
    {
        return view('livewire.admin.booking-request-list', [
            'requests' => BookingRequest::with(['room', 'roomType'])
                ->latest()
                ->get(),
        ]);
    }
}
