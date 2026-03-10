<?php

namespace App\Livewire\Admin;

use App\Models\Voucher;
use App\Models\Hotel;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class VoucherCrud extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $voucherId;

    // Form fields
    public $code;
    public $name;
    public $description;
    public $discount_type = 'percentage';
    public $discount_value;
    public $max_discount_amount;
    public $min_purchase;
    public $min_nights;
    public $applicable_hotel_ids = [];
    public $applicable_room_ids = [];
    public $valid_from;
    public $valid_until;
    public $total_quantity;
    public $max_usage_per_user = 1;
    public $voucher_type = 'public';
    public $is_active = true;

    public $search = '';
    public $filterType = '';
    public $filterStatus = '';

    protected $queryString = ['search', 'filterType', 'filterStatus'];

    public function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:vouchers,code,' . $this->voucherId,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_nights' => 'nullable|integer|min:1',
            'applicable_hotel_ids' => 'nullable|array',
            'applicable_room_ids' => 'nullable|array',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'total_quantity' => 'nullable|integer|min:1',
            'max_usage_per_user' => 'required|integer|min:1',
            'voucher_type' => 'required|in:public,private,referral',
            'is_active' => 'boolean',
        ];
    }

    public function generateCode()
    {
        $this->code = strtoupper(Str::random(8));
    }

    public function openModal()
    {
        $this->resetForm();
        $this->generateCode();
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
            'editMode', 'voucherId', 'code', 'name', 'description',
            'discount_type', 'discount_value', 'max_discount_amount',
            'min_purchase', 'min_nights', 'applicable_hotel_ids',
            'applicable_room_ids', 'valid_from', 'valid_until',
            'total_quantity', 'max_usage_per_user', 'voucher_type', 'is_active'
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => strtoupper($this->code),
            'name' => $this->name,
            'description' => $this->description,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'max_discount_amount' => $this->max_discount_amount,
            'min_purchase' => $this->min_purchase,
            'min_nights' => $this->min_nights,
            'applicable_hotel_ids' => $this->applicable_hotel_ids ?: null,
            'applicable_room_ids' => $this->applicable_room_ids ?: null,
            'valid_from' => $this->valid_from,
            'valid_until' => $this->valid_until,
            'total_quantity' => $this->total_quantity,
            'max_usage_per_user' => $this->max_usage_per_user,
            'voucher_type' => $this->voucher_type,
            'is_active' => $this->is_active,
        ];

        if ($this->editMode) {
            $voucher = Voucher::findOrFail($this->voucherId);
            $voucher->update($data);
            session()->flash('message', 'Voucher berhasil diperbarui!');
        } else {
            Voucher::create($data);
            session()->flash('message', 'Voucher berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        
        $this->editMode = true;
        $this->voucherId = $voucher->id;
        $this->code = $voucher->code;
        $this->name = $voucher->name;
        $this->description = $voucher->description;
        $this->discount_type = $voucher->discount_type;
        $this->discount_value = $voucher->discount_value;
        $this->max_discount_amount = $voucher->max_discount_amount;
        $this->min_purchase = $voucher->min_purchase;
        $this->min_nights = $voucher->min_nights;
        $this->applicable_hotel_ids = $voucher->applicable_hotel_ids ?? [];
        $this->applicable_room_ids = $voucher->applicable_room_ids ?? [];
        $this->valid_from = $voucher->valid_from->format('Y-m-d');
        $this->valid_until = $voucher->valid_until->format('Y-m-d');
        $this->total_quantity = $voucher->total_quantity;
        $this->max_usage_per_user = $voucher->max_usage_per_user;
        $this->voucher_type = $voucher->voucher_type;
        $this->is_active = $voucher->is_active;

        $this->showModal = true;
    }

    public function delete($id)
    {
        Voucher::findOrFail($id)->delete();
        session()->flash('message', 'Voucher berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_active' => !$voucher->is_active]);
        session()->flash('message', 'Status voucher berhasil diubah!');
    }

    public function render()
    {
        $vouchers = Voucher::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('voucher_type', $this->filterType);
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        $hotels = Hotel::all();
        $rooms = Room::with('hotel')->get();

        return view('livewire.admin.voucher-crud', [
            'vouchers' => $vouchers,
            'hotels' => $hotels,
            'rooms' => $rooms,
        ]);
    }
}