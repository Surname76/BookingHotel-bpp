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
                        Kelola Voucher
                    </h1>
                </div>
                <p class="text-slate-500">
                    Atur dan kelola voucher untuk pelanggan Anda
                </p>
            </div>

            <button wire:click="openModal" class="group flex items-center gap-2 px-6 py-3 bg-blue-900 text-white rounded-xl hover:bg-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">Tambah Voucher</span>
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
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cari Voucher</label>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau kode..." 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Voucher</label>
                    <select wire:model.live="filterType" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Tipe</option>
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                        <option value="referral">Referral</option>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Voucher</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Penggunaan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($vouchers as $voucher)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $voucher->name }}</div>
                                    @if($voucher->description)
                                        <div class="text-sm text-slate-500 line-clamp-1">{{ $voucher->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <code class="px-3 py-1 bg-slate-100 text-slate-800 rounded font-mono text-sm font-semibold">
                                            {{ $voucher->code }}
                                        </code>
                                        <button onclick="navigator.clipboard.writeText('{{ $voucher->code }}')" 
                                            class="text-slate-400 hover:text-blue-600 transition" title="Salin kode">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">
                                        @if($voucher->discount_type === 'percentage')
                                            {{ $voucher->discount_value }}%
                                            @if($voucher->max_discount_amount)
                                                <div class="text-xs text-slate-500">Maks. Rp {{ number_format($voucher->max_discount_amount, 0, ',', '.') }}</div>
                                            @endif
                                        @else
                                            Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($voucher->voucher_type === 'public') bg-green-100 text-green-700
                                        @elseif($voucher->voucher_type === 'private') bg-purple-100 text-purple-700
                                        @else bg-orange-100 text-orange-700
                                        @endif">
                                        {{ ucfirst($voucher->voucher_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>{{ $voucher->valid_from->format('d M Y') }}</div>
                                    <div>{{ $voucher->valid_until->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    @if($voucher->total_quantity)
                                        <div>{{ $voucher->used_quantity }} / {{ $voucher->total_quantity }}</div>
                                        <div class="w-full bg-slate-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ ($voucher->used_quantity / $voucher->total_quantity) * 100 }}%"></div>
                                        </div>
                                    @else
                                        <div class="text-slate-400">Unlimited</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="toggleStatus({{ $voucher->id }})" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $voucher->is_active ? 'bg-blue-600' : 'bg-slate-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $voucher->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="edit({{ $voucher->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $voucher->id }})" wire:confirm="Yakin ingin menghapus voucher ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada voucher</p>
                                    <p class="text-sm mt-1">Klik tombol "Tambah Voucher" untuk membuat voucher baru</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($vouchers->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $vouchers->links() }}
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
                                {{ $editMode ? 'Edit Voucher' : 'Tambah Voucher Baru' }}
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
                                    
                                    <!-- Nama Voucher -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Voucher *</label>
                                        <input type="text" wire:model="name" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Kode Voucher -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Voucher *</label>
                                        <div class="flex gap-2">
                                            <input type="text" wire:model="code" 
                                                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono uppercase @error('code') border-red-500 @enderror">
                                            <button type="button" wire:click="generateCode" 
                                                class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Tipe Voucher -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Voucher *</label>
                                        <select wire:model="voucher_type" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('voucher_type') border-red-500 @enderror">
                                            <option value="public">Public - Semua orang</option>
                                            <option value="private">Private - Khusus tertentu</option>
                                            <option value="referral">Referral - Dari referensi</option>
                                        </select>
                                        @error('voucher_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Tipe Nilai Diskon -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Nilai *</label>
                                        <select wire:model.live="discount_type" 
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
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_value') border-red-500 @enderror"
                                            placeholder="{{ $discount_type === 'percentage' ? 'Contoh: 20' : 'Contoh: 50000' }}">
                                        @error('discount_value') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Max Diskon (untuk percentage) -->
                                    @if($discount_type === 'percentage')
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Maks. Potongan (Rp)</label>
                                            <input type="number" step="0.01" wire:model="max_discount_amount" 
                                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Kosongkan untuk unlimited">
                                        </div>
                                    @endif

                                    <!-- Min Purchase -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Min. Transaksi (Rp)</label>
                                        <input type="number" step="0.01" wire:model="min_purchase" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Min Nights -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Min. Malam Menginap</label>
                                        <input type="number" wire:model="min_nights" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

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

                                    <!-- Quantity -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Total Voucher Tersedia</label>
                                        <input type="number" wire:model="total_quantity" placeholder="Kosongkan untuk unlimited"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Maks. Per User *</label>
                                        <input type="number" wire:model="max_usage_per_user"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_usage_per_user') border-red-500 @enderror">
                                        @error('max_usage_per_user') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                                        <textarea wire:model="description" rows="3" 
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                    </div>

                                    <!-- Toggle Active -->
                                    <div class="md:col-span-2">
                                        <label class="flex items-center gap-3">
                                            <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-5 h-5">
                                            <span class="text-sm font-medium text-slate-700">Aktifkan voucher ini</span>
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