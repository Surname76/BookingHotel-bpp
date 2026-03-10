<?php

namespace App\Livewire\Admin;

use App\Models\Discount;
use App\Models\Hotel;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DiscountCrud extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $discountId;

    // Form fields
    public $name;
    public $code;
    public $description;
    public $type = 'room_type';
    public $discount_type = 'percentage';
    public $discount_value;
    public $min_nights;
    public $min_amount;
    public $applicable_room_types = [];
    public $applicable_days = [];
    public $applicable_hotel_ids = [];
    public $applicable_room_ids = [];
    public $valid_from;
    public $valid_until;
    public $max_usage;
    public $max_usage_per_user;
    public $is_active = true;
    public $is_stackable = false;

    public $search = '';
    public $filterType = '';
    public $filterStatus = '';

    protected $queryString = ['search', 'filterType', 'filterStatus'];

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:discounts,code,' . $this->discountId,
            'description' => 'nullable|string',
            'type' => 'required|in:room_type,extended_stay,weekday,seasonal,early_bird',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_nights' => 'nullable|integer|min:1',
            'min_amount' => 'nullable|numeric|min:0',
            'applicable_room_types' => 'nullable|array',
            'applicable_days' => 'nullable|array',
            'applicable_hotel_ids' => 'nullable|array',
            'applicable_room_ids' => 'nullable|array',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'max_usage' => 'nullable|integer|min:1',
            'max_usage_per_user' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_stackable' => 'boolean',
        ];
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'editMode', 'discountId', 'name', 'code', 'description', 'type',
            'discount_type', 'discount_value', 'min_nights', 'min_amount',
            'applicable_room_types', 'applicable_days', 'applicable_hotel_ids',
            'applicable_room_ids', 'valid_from', 'valid_until', 'max_usage',
            'max_usage_per_user', 'is_active', 'is_stackable'
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'type' => $this->type,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_nights' => $this->min_nights,
            'min_amount' => $this->min_amount,
            'applicable_room_types' => $this->applicable_room_types ?: null,
            'applicable_days' => $this->applicable_days ?: null,
            'applicable_hotel_ids' => $this->applicable_hotel_ids ?: null,
            'applicable_room_ids' => $this->applicable_room_ids ?: null,
            'valid_from' => $this->valid_from,
            'valid_until' => $this->valid_until,
            'max_usage' => $this->max_usage,
            'max_usage_per_user' => $this->max_usage_per_user,
            'is_active' => $this->is_active,
            'is_stackable' => $this->is_stackable,
        ];

        if ($this->editMode) {
            $discount = Discount::findOrFail($this->discountId);
            $discount->update($data);
            session()->flash('message', 'Diskon berhasil diperbarui!');
        } else {
            Discount::create($data);
            session()->flash('message', 'Diskon berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        
        $this->editMode = true;
        $this->discountId = $discount->id;
        $this->name = $discount->name;
        $this->code = $discount->code;
        $this->description = $discount->description;
        $this->type = $discount->type;
        $this->discount_type = $discount->discount_type;
        $this->discount_value = $discount->discount_value;
        $this->min_nights = $discount->min_nights;
        $this->min_amount = $discount->min_amount;
        $this->applicable_room_types = $discount->applicable_room_types ?? [];
        $this->applicable_days = $discount->applicable_days ?? [];
        $this->applicable_hotel_ids = $discount->applicable_hotel_ids ?? [];
        $this->applicable_room_ids = $discount->applicable_room_ids ?? [];
        $this->valid_from = $discount->valid_from->format('Y-m-d');
        $this->valid_until = $discount->valid_until->format('Y-m-d');
        $this->max_usage = $discount->max_usage;
        $this->max_usage_per_user = $discount->max_usage_per_user;
        $this->is_active = $discount->is_active;
        $this->is_stackable = $discount->is_stackable;

        $this->showModal = true;
    }

    public function delete($id)
    {
        Discount::findOrFail($id)->delete();
        session()->flash('message', 'Diskon berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update(['is_active' => !$discount->is_active]);
        session()->flash('message', 'Status diskon berhasil diubah!');
    }

    public function render()
    {
        $discounts = Discount::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        $hotels = Hotel::all();
        $rooms = Room::with('hotel')->get();

        return view('livewire.admin.discount-crud', [
            'discounts' => $discounts,
            'hotels' => $hotels,
            'rooms' => $rooms,
        ]);
    }
}