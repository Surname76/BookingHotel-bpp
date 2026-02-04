<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewBookingRequestNotification;

#[Layout('layouts.app')]
class BookingRequestList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $selectedRequest = null;
    public $adminNote = '';

    public $search = '';

    public function mount(): void
    {
        $user = auth()->user();

        if ($user) {
            $user->unreadNotifications()
                ->where('type', NewBookingRequestNotification::class)
                ->update(['read_at' => now()]);
        }
    }

    // Reset halaman ke 1 jika user mengetik sesuatu (agar tidak error pagination)
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function select(int $id): void
    {
        $this->selectedRequest = BookingRequest::with(['room.hotel', 'latestPayment'])
            ->findOrFail($id);

        $this->adminNote = $this->selectedRequest->note;
    }

    public function updateStatus(string $status): void
    {
        if (! $this->selectedRequest) {
            return;
        }

        DB::transaction(function () use ($status) {
            if ($status === 'sent') {
                if ($this->selectedRequest->status === 'confirmed') {
                    return;
                }

                $this->selectedRequest->update([
                    'status' => 'sent',
                    'note'   => $this->adminNote,
                ]);
            }

            if ($status === 'rejected') {
                if ($this->selectedRequest->status === 'confirmed') {
                    return;
                }

                $this->selectedRequest->update([
                    'status' => 'rejected',
                    'note' => $this->adminNote,
                ]);
            }
        });

        session()->flash('message', 'Status booking berhasil diproses.');

        $this->reset(['selectedRequest', 'adminNote']);
    }

    public function closeModal(): void
    {
        $this->selectedRequest = null;
        $this->adminNote = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $requests = BookingRequest::with(['room.hotel', 'latestPayment'])
            ->whereNull('cancelled_at')
            ->when($this->search, function ($query) {
                $query->where('guest_name', 'like', '%' . $this->search . '%')
                    ->orWhere('guest_email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.booking-request-list', [
            'requests' => $requests,
        ]);
    }
}
