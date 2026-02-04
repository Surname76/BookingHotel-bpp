<div class="min-h-screen bg-slate-50 py-10 px-6 sm:px-8 lg:px-12">
    <div class="max-w-7xl mx-auto">

        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Hotel</h1>
                <p class="text-slate-500 mt-1">Kelola daftar properti, harga, dan ketersediaan kamar.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right mr-2">
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Properti</p>
                    <p class="text-xl font-bold text-blue-900 leading-none">{{ count($hotels) }}</p>
                </div>

                <button wire:click="create"
                    class="group inline-flex items-center gap-2 px-5 py-2.5 bg-blue-900 text-white rounded-xl text-sm font-semibold shadow-md hover:bg-blue-800 hover:shadow-lg transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-blue-900">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Hotel</span>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            <th class="px-6 py-4">Properti</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Harga / Malam</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($hotels as $hotel)
                            <tr class="group hover:bg-blue-50/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="relative h-12 w-12 flex-shrink-0 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                                            @if ($hotel->image_url)
                                                <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                                                    class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="h-full w-full flex items-center justify-center text-slate-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div
                                                class="font-bold text-slate-800 group-hover:text-blue-900 transition-colors">
                                                {{ $hotel->name }}</div>
                                            <div class="text-xs text-slate-500 line-clamp-1">{{ $hotel->description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                        <svg class="w-3 h-3 mr-1.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $hotel->district }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono font-medium text-slate-700">
                                    Rp {{ number_format($hotel->price_per_night, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($hotel->is_available)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <span class="relative flex h-2 w-2">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                            Penuh
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $hotel->id }})"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all border border-transparent hover:border-blue-100"
                                            title="Edit Hotel">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <button wire:click="selectHotel({{ $hotel->id }})"
                                            class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 rounded-lg transition-all shadow-sm border border-blue-100"
                                            title="Kelola Kamar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </button>

                                        <button wire:click="delete({{ $hotel->id }})"
                                            onclick="confirm('Yakin ingin menghapus hotel ini?') || event.stopImmediatePropagation()"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all border border-transparent hover:border-red-100"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="h-16 w-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-base font-medium text-slate-900">Belum ada data hotel</p>
                                        <p class="text-sm text-slate-500 mt-1">Mulai dengan menambahkan properti baru.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@if ($showHotelModal ?? false)
    <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Overlay Backdrop --}}
        <div wire:transition.opacity.duration.300ms
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"
            wire:click="closeHotelModal"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6">
                
                {{-- Container Modal: Diubah ke max-w-5xl agar bisa Landscape --}}
                <div wire:transition.scale.origin.center.duration.300ms
                    class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all w-full max-w-5xl border border-slate-100">

                    {{-- Header --}}
                    <div class="bg-white px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">
                                {{ $isEdit ? 'Edit Data Hotel' : 'Tambah Hotel Baru' }}
                            </h3>
                            <p class="text-sm text-slate-500 font-medium">Lengkapi informasi properti untuk manajemen inventaris.</p>
                        </div>
                        <button wire:click="closeHotelModal"
                            class="text-slate-400 hover:text-slate-600 transition-all bg-slate-50 p-2 rounded-full hover:rotate-90">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                        <div class="p-8">
                            {{-- Grid Utama Landscape --}}
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                                
                                {{-- KOLOM KIRI: Identitas Utama --}}
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Nama Hotel Properti</label>
                                        <input type="text" wire:model.defer="name"
                                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:ring-4 focus:ring-blue-500/10 transition-all placeholder-slate-400"
                                            placeholder="Contoh: Hotel Grand Wisata">
                                        @error('name')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Distrik / Wilayah</label>
                                            <select wire:model.defer="district"
                                                class="w-full rounded-lg border border-slate-300 shadow-sm text-sm focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all py-2.5 pl-3 pr-10 appearance-none bg-white">
                                                <option value="">Pilih Distrik</option>
                                                @foreach ($districts as $dist)
                                                    <option value="{{ $dist }}">{{ $dist }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Harga / Malam</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-5 flex items-center text-slate-400 font-bold text-xs">Rp</span>
                                                <input type="number" wire:model.defer="price_per_night"
                                                    class="w-full pl-12 pr-5 py-4 rounded-2xl border-none bg-slate-50 text-sm font-bold focus:ring-4 focus:ring-blue-500/10 transition-all"
                                                    placeholder="0">
                                            </div>
                                        </div>
                                        @error('district')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">
                                            Link Google Maps
                                        </label>
                                        <input type="url" wire:model.defer="map_link"
                                            class="w-full rounded-lg border border-slate-300 shadow-sm text-sm focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all py-2.5"
                                            placeholder="https://maps.app.goo.gl/...">
                                        @error('map_link')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Thumbnail Gambar (URL)</label>
                                        <input type="text" wire:model.defer="image_url"
                                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 transition-all"
                                            placeholder="https://images.unsplash.com/...">
                                    </div>
                                </div>

                                {{-- KOLOM KANAN: Deskripsi & Fasilitas --}}
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Deskripsi Singkat</label>
                                        <textarea wire:model.defer="description" rows="2"
                                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 transition-all"
                                            placeholder="Jelaskan fasilitas utama..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Tentang Properti</label>
                                        <textarea wire:model.defer="about_property" rows="3"
                                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 transition-all"
                                            placeholder="Ceritakan sejarah atau keunggulan lokasi..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Fasilitas Umum (1 per baris)</label>
                                        <textarea wire:model.defer="general_facilities" rows="3"
                                            class="w-full rounded-2xl border-none bg-slate-100 px-5 py-4 text-sm font-mono focus:ring-4 focus:ring-blue-500/10 transition-all"
                                            placeholder="Wifi Gratis&#10;Kolam Renang&#10;Parkir Luas"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Action --}}
                        <div class="bg-slate-50 px-8 py-6 flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" wire:model="is_available" class="sr-only">
                                    <div class="block bg-slate-200 w-10 h-6 rounded-full group-hover:bg-slate-300 transition-colors"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform {{ $is_available ? 'translate-x-4 bg-blue-600' : '' }}"></div>
                                </div>
                                <span class="ml-3 text-xs font-black text-slate-600 uppercase tracking-widest">Tersedia untuk Dipesan</span>
                            </label>

                            <div class="flex space-x-4">
                                <button type="button" wire:click="closeHotelModal"
                                    class="px-6 py-3 text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-800 transition-colors">
                                    Batal
                                </button>
                                <button type="submit" wire:loading.attr="disabled"
                                    class="px-8 py-3 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] hover:bg-blue-600 shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center gap-3">
                                    <svg wire:loading class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ $isEdit ? 'Update Hotel' : 'Simpan Hotel' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endif

    @if ($selectedHotelId ?? false)
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div wire:transition.opacity.duration.300ms
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                wire:click="$set('selectedHotelId', null)"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div wire:transition.scale.origin.center.duration.300ms
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-5xl border border-slate-100 flex flex-col max-h-[90vh]">

                        <div
                            class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Manajemen Kamar</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Kelola tipe kamar untuk hotel yang dipilih.
                                </p>
                            </div>
                            <button wire:click="$set('selectedHotelId', null)"
                                class="text-slate-400 hover:text-slate-600 transition-colors bg-white p-1 rounded-md border border-slate-200 shadow-sm hover:bg-slate-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 overflow-y-auto">
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 mb-8 shadow-sm">
                                <div class="flex justify-between items-center mb-4">
                                    <h4
                                        class="text-sm font-bold text-blue-900 uppercase tracking-wide flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $isEditingRoom ? 'Edit Kamar' : 'Input Kamar Baru' }}
                                    </h4>
                                    @if ($isEditingRoom)
                                        <button wire:click="cancelRoomEdit"
                                            class="text-xs text-red-600 hover:underline">Batal Edit</button>
                                    @endif
                                </div>

                                <form wire:submit.prevent="{{ $isEditingRoom ? 'updateRoom' : 'storeRoom' }}">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-slate-500 mb-1 block">Nama
                                                Kamar</label>
                                            <input type="text" wire:model.defer="room_name"
                                                class="w-full rounded-lg border border-slate-300 text-sm focus:ring-blue-900 focus:border-blue-900 py-2"
                                                placeholder="Ex: Deluxe Room">
                                            @error('room_name')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-semibold text-slate-500 mb-1 block">Kapasitas</label>
                                            <input type="number" wire:model.defer="room_capacity"
                                                class="w-full rounded-lg border border-slate-300 text-sm focus:ring-blue-900 focus:border-blue-900 py-2"
                                                placeholder="2">
                                        </div>
                                        <div class="md:col-span-1">
                                            <label
                                                class="text-xs font-semibold text-slate-500 mb-1 block">Harga</label>
                                            <input type="number" wire:model.defer="room_price_per_night"
                                                class="w-full rounded-lg border border-slate-300 text-sm focus:ring-blue-900 focus:border-blue-900 py-2"
                                                placeholder="Rp">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-slate-500 mb-1 block">Fasilitas
                                                (JSON)</label>
                                            <input type="text" wire:model.defer="room_benefits"
                                                placeholder='["AC", "WiFi"]'
                                                class="w-full rounded-lg border border-slate-300 text-sm focus:ring-blue-900 focus:border-blue-900 py-2 font-mono text-xs">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-semibold text-slate-500 mb-1 block">Deskripsi
                                                Singkat</label>
                                            <input type="text" wire:model.defer="room_description"
                                                class="w-full rounded-lg border border-slate-300 text-sm focus:ring-blue-900 focus:border-blue-900 py-2">
                                        </div>

                                        <div class="md:col-span-4 flex items-center justify-between pt-2">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" wire:model="room_is_available"
                                                    class="rounded border-slate-300 text-blue-900 focus:ring-blue-900 h-4 w-4 bg-white">
                                                <span
                                                    class="ml-2 text-xs font-semibold text-slate-600 uppercase">Status
                                                    Tersedia</span>
                                            </label>
                                            <button type="submit"
                                                class="px-5 py-2 bg-blue-900 text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition shadow-sm">
                                                {{ $isEditingRoom ? 'Update Data Kamar' : 'Tambahkan Kamar' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <h4 class="text-sm font-bold text-slate-800 mb-3 ml-1">Daftar Kamar</h4>
                            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                                <table class="min-w-full divide-y divide-slate-100">
                                    <thead class="bg-slate-50 text-slate-500">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Nama</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Kapasitas</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold uppercase">Harga</th>
                                            <th class="px-4 py-3 text-center text-xs font-bold uppercase">Status</th>
                                            <th class="px-4 py-3 text-center text-xs font-bold uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-100">
                                        @forelse($rooms as $room)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-4 py-3 text-sm font-medium text-slate-900">
                                                    {{ $room->name }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-500">{{ $room->capacity }}
                                                    Orang</td>
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-700">Rp
                                                    {{ number_format($room->price_per_night, 0, ',', '.') }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <span
                                                        class="inline-block w-2.5 h-2.5 rounded-full {{ $room->is_available ? 'bg-emerald-500' : 'bg-red-500' }}"
                                                        title="{{ $room->is_available ? 'Tersedia' : 'Penuh' }}"></span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <div class="flex items-center justify-center space-x-1">
                                                        <button wire:click="editRoom({{ $room->id }})"
                                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><svg
                                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
                                                            </svg></button>
                                                        <button wire:click="deleteRoom({{ $room->id }})"
                                                            onclick="confirm('Hapus kamar ini?') || event.stopImmediatePropagation()"
                                                            class="p-1.5 text-red-600 hover:bg-red-50 rounded"><svg
                                                                class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="px-4 py-8 text-center text-sm text-slate-500 italic">
                                                    Belum ada kamar yang terdaftar. Gunakan form di atas untuk menambah.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
