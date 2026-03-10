<div class="min-h-screen bg-slate-50 py-10 px-6 sm:px-8 lg:px-12">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-slate-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                        Kelola Diskon
                    </h1>
                </div>
                <p class="text-slate-500">
                    Atur dan kelola diskon untuk hotel Anda
                </p>
            </div>

            <button wire:click="openModal" class="group flex items-center gap-2 px-6 py-3 bg-blue-900 text-white rounded-xl hover:bg-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">Tambah Diskon</span>
            </button>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cari Diskon</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau kode..." 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Diskon</label>
                    <select wire:model.live="filterType" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Tipe</option>
                        <option value="room_type">Tipe Kamar</option>
                        <option value="extended_stay">Extended Stay</option>
                        <option value="weekday">Weekday</option>
                        <option value="seasonal">Seasonal</option>
                        <option value="early_bird">Early Bird</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select wire:model.live="filterStatus" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Diskon</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Penggunaan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($discounts as $discount)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $discount->name }}</div>
                                    @if($discount->code)
                                        <div class="text-sm text-slate-500">Kode: {{ $discount->code }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($discount->type === 'room_type') bg-purple-100 text-purple-700
                                        @elseif($discount->type === 'extended_stay') bg-blue-100 text-blue-700
                                        @elseif($discount->type === 'weekday') bg-green-100 text-green-700
                                        @elseif($discount->type === 'seasonal') bg-orange-100 text-orange-700
                                        @else bg-pink-100 text-pink-700
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $discount->type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">
                                        @if($discount->discount_type === 'percentage')
                                            {{ $discount->discount_value }}%
                                        @else
                                            Rp {{ number_format($discount->discount_value, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>{{ $discount->valid_from->format('d M Y') }}</div>
                                    <div>{{ $discount->valid_until->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    @if($discount->max_usage)
                                        <div>{{ $discount->usage_count }} / {{ $discount->max_usage }}</div>
                                    @else
                                        <div class="text-slate-400">Unlimited</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $discount->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $discount->is_active ? 'bg-blue-600' : 'bg-slate-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $discount->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="edit({{ $discount->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $discount->id }})" wire:confirm="Yakin ingin menghapus diskon ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada diskon</p>
                                    <p class="text-sm mt-1">Klik tombol "Tambah Diskon" untuk membuat diskon baru</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($discounts->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $discounts->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Form -->
        @if($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                    <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                            <h3 class="text-xl font-bold text-slate-900">
                                {{ $editMode ? 'Edit Diskon' : 'Tambah Diskon Baru' }}
                            </h3>
                            <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <form wire:submit.prevent="save">
                            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    <!-- Nama Diskon -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Diskon *</label>
                                        <input type="text" wire:model="name" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Kode Promo -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Promo (Opsional)</label>
                                        <input type="text" wire:model="code" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror">
                                        @error('code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Tipe Diskon -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Diskon *</label>
                                        <select wire:model.live="type" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                                            <option value="room_type">Tipe Kamar (Single/Twin)</option>
                                            <option value="extended_stay">Extended Stay</option>
                                            <option value="weekday">Weekday</option>
                                            <option value="seasonal">Seasonal</option>
                                            <option value="early_bird">Early Bird</option>
                                        </select>
                                        @error('type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Tipe Nilai Diskon -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Nilai *</label>
                                        <select wire:model="discount_type" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_type') border-red-500 @enderror">
                                            <option value="percentage">Persentase (%)</option>
                                            <option value="fixed">Nominal (Rp)</option>
                                        </select>
                                        @error('discount_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Nilai Diskon -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nilai Diskon *</label>
                                        <input type="number" step="0.01" wire:model="discount_value" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_value') border-red-500 @enderror">
                                        @error('discount_value') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Kondisi -->
                                    @if($type === 'extended_stay')
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Malam</label>
                                            <input type="number" wire:model="min_nights" 
                                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                    @endif

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Transaksi (Rp)</label>
                                        <input type="number" step="0.01" wire:model="min_amount" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Tipe Kamar -->
                                    @if($type === 'room_type')
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Kamar yang Berlaku</label>
                                            <div class="flex flex-wrap gap-3">
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_room_types" value="single" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Single Bed</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_room_types" value="twin" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Twin Bed</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_room_types" value="double" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Double Bed</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Hari Berlaku -->
                                    @if($type === 'weekday')
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Hari yang Berlaku</label>
                                            <div class="flex flex-wrap gap-3">
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Senin</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="2" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Selasa</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="3" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Rabu</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="4" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Kamis</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="5" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Jumat</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="6" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Sabtu</span>
                                                </label>
                                                <label class="flex items-center gap-2">
                                                    <input type="checkbox" wire:model="applicable_days" value="0" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-slate-700">Minggu</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Periode Berlaku -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Berlaku Dari *</label>
                                        <input type="date" wire:model="valid_from" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valid_from') border-red-500 @enderror">
                                        @error('valid_from') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Berlaku Sampai *</label>
                                        <input type="date" wire:model="valid_until" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valid_until') border-red-500 @enderror">
                                        @error('valid_until') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Batasan Penggunaan -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Maks. Total Penggunaan</label>
                                        <input type="number" wire:model="max_usage" placeholder="Kosongkan untuk unlimited"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Maks. Per User</label>
                                        <input type="number" wire:model="max_usage_per_user" placeholder="Kosongkan untuk unlimited"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                                        <textarea wire:model="description" rows="3" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                    </div>

                                    <!-- Toggle Options -->
                                    <div class="md:col-span-2 space-y-3">
                                        <label class="flex items-center gap-3">
                                            <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-5 h-5">
                                            <span class="text-sm font-medium text-slate-700">Aktifkan diskon ini</span>
                                        </label>
                                        <label class="flex items-center gap-3">
                                            <input type="checkbox" wire:model="is_stackable" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-5 h-5">
                                            <span class="text-sm font-medium text-slate-700">Dapat digabung dengan diskon lain</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-200">
                                <button type="button" wire:click="closeModal" 
                                    class="px-6 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition shadow-lg">
                                    {{ $editMode ? 'Update' : 'Simpan' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>