<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Hotel;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Home extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $filter = 'Semua';
    public int $perPage = 9;

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = Hotel::query();

        $query->select([
            'id',
            'name',
            'district',
            'map_link',
            'image_url',
            'description',
            'is_available',
            'created_at',
        ]);

        if ($this->filter !== 'Semua') {
            $fullDistrict = 'Balikpapan '.$this->filter;
            $query->where('district', $fullDistrict);
        }

        $query->with(['rooms' => function ($q) {
            $q->select(['id', 'hotel_id', 'name', 'price_per_night', 'is_available'])
                ->where('is_available', true);
        }]);

        $query->where('is_available', true);

        $hotels = $query->latest()->paginate($this->perPage);

        return view('livewire.pages.home', [
            'hotels' => $hotels,
        ]);
    }
}