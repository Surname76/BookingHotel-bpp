<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Hotel;
use Livewire\Attributes\Layout;

class Home extends Component
{
    public string $filter = 'Semua';

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function getHotelsProperty()
    {
        $query = Hotel::query();

        // LOGIKA FILTER DIPERBAIKI DISINI
        if ($this->filter !== 'Semua') {
            // Kita tambahkan "Balikpapan " di depannya agar cocok dengan data database
            // Contoh: Filter "Selatan" menjadi "Balikpapan Selatan"
            $fullDistrict = 'Balikpapan ' . $this->filter;
            
            $query->where('district', $fullDistrict);
        }

        // Eager load rooms untuk efisiensi query harga
        $query->with(['rooms' => function($q) {
            $q->where('is_available', true);
        }]);

        // Hanya tampilkan hotel yang aktif
        $query->where('is_available', true);

        return $query->latest()->get();
    }

    public function render()
    {
        return view('livewire.pages.home', [
            'hotels' => $this->hotels,
        ]);
    }
}