<?php

namespace App\Livewire\Payments;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Pembayaran')]
#[Layout('layouts.app')]
class ReturnPage extends Component
{
    public string $status = 'success';

    public function mount(string $status = 'success'): void
    {
        $this->status = in_array($status, ['success', 'failure'], true) ? $status : 'success';
    }

    public function render()
    {
        return view('livewire.payments.return-page', [
            'status' => $this->status,
        ]);
    }
}
