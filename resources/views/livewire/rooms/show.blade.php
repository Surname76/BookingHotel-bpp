<div class="bg-slate-50 min-h-screen text-slate-900 font-sans pb-20">

    {{-- SECTION 1: HERO & HOTEL INFO --}}
    <section class="relative h-[50vh] md:h-[65vh] overflow-hidden group">
        <div class="absolute inset-0 bg-slate-900">
            @if ($hotel->image_url)
                <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                    class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-1000" />
            @else
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&fit=crop"
                    class="w-full h-full object-cover opacity-70" />
            @endif
        </div>

        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/20 to-transparent"></div>

        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-6 pb-16 w-full">
                <span
                    class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-medium px-4 py-1.5 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $hotel->district }}, Balikpapan
                </span>

                <h1 class="text-4xl md:text-6xl font-bold text-white drop-shadow-2xl tracking-tight mb-4">
                    {{ $hotel->name }}
                </h1>

                <p class="text-slate-300 text-lg max-w-2xl line-clamp-2 leading-relaxed">
                    {{ $hotel->description ?? 'Nikmati pengalaman menginap terbaik dengan pelayanan istimewa di jantung kota Balikpapan.' }}
                </p>
            </div>
        </div>
    </section>

    {{-- SECTION 2: CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-3 gap-12">

        {{-- LEFT COLUMN: ROOMS LIST --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="flex items-end justify-between border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Pilihan Kamar</h2>
                    <p class="text-sm text-slate-500 mt-1">Harga terbaik untuk masa inap Anda</p>
                </div>
                <span
                    class="text-xs font-bold uppercase tracking-wider bg-slate-100 px-3 py-1 rounded-full text-slate-600">
                    {{ $hotel->rooms->count() }} Tipe
                </span>
            </div>

            <div class="space-y-6">
                @forelse($hotel->rooms as $room)
                    <div
                        class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col md:flex-row">

                        {{-- Room Info --}}
                        <div class="flex-1 p-6 md:p-8 space-y-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-bold text-slate-800">{{ $room->name }}</h3>
                                <div
                                    class="flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 15.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ $room->capacity }} Orang
                                </div>
                            </div>

                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $room->description ?? 'Kamar nyaman dengan fasilitas lengkap untuk istirahat Anda.' }}
                            </p>

                            @if (!empty($room->benefits))
                                <div class="flex flex-wrap gap-2 pt-2">
                                    @foreach ($room->benefits as $benefit)
                                        <span
                                            class="text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 border border-blue-100">
                                            {{ $benefit }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Price & Action --}}
                        <div
                            class="bg-slate-50/50 md:w-56 p-6 md:p-8 flex flex-col justify-center items-center md:items-end border-t md:border-t-0 md:border-l border-slate-100 gap-4">
                            <div class="text-center md:text-right">
                                <span
                                    class="block text-[10px] uppercase font-bold text-slate-400 tracking-[0.1em] mb-1">Mulai
                                    Dari</span>
                                <span class="block text-2xl font-black text-blue-600">
                                    Rp{{ number_format($room->price_per_night, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-slate-400">/ malam</span>
                            </div>

                            <button wire:click="openBookingModal({{ $room->id }})"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-xl font-bold text-sm hover:bg-blue-700 shadow-md shadow-blue-200 transition-all transform active:scale-95">
                                Booking
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                        <p class="text-slate-400 font-medium">Belum ada kamar yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT COLUMN: STICKY DETAILS & MAPS --}}
        <div class="space-y-6">
            <div class="sticky top-10 space-y-6">

                {{-- Hotel Highlights Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-lg mb-4 text-slate-900">Tentang Properti</h3>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        {{ $hotel->description }}
                    </p>

                    <h4 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-4 font-mono">Fasilitas Umum
                    </h4>
                    <ul class="grid grid-cols-1 gap-3 text-sm text-slate-600">
                        <li class="flex items-center gap-3 bg-slate-50 p-2 rounded-lg"><span
                                class="text-blue-500">✔</span> Wifi Gratis</li>
                        <li class="flex items-center gap-3 bg-slate-50 p-2 rounded-lg"><span
                                class="text-blue-500">✔</span> Parkir Luas</li>
                        <li class="flex items-center gap-3 bg-slate-50 p-2 rounded-lg"><span
                                class="text-blue-500">✔</span> Resepsionis 24 Jam</li>
                        <li class="flex items-center gap-3 bg-slate-50 p-2 rounded-lg"><span
                                class="text-blue-500">✔</span> Full AC</li>
                    </ul>
                </div>

                {{-- GOOGLE MAP PREVIEW --}}
                @if ($hotel->map_link)
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            Lokasi Hotel
                        </h3>

                        <a href="{{ $hotel->map_link }}" target="_blank" class="block group">
                            <div class="relative overflow-hidden rounded-lg border">
                                <iframe class="w-full h-64 pointer-events-none" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps?q={{ urlencode($hotel->name . ' ' . $hotel->district) }}&output=embed">
                                </iframe>

                                {{-- Overlay klik --}}
                                <div
                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                                    <span
                                        class="opacity-0 group-hover:opacity-100 bg-white px-4 py-2 rounded-lg text-sm font-semibold shadow">
                                        Buka di Google Maps
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif



                {{-- Help Card --}}
                <div
                    class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                    <h3 class="font-bold text-lg mb-1">Butuh Bantuan?</h3>
                    <p class="text-blue-100 text-xs mb-4">Tim kami siap membantu proses reservasi Anda 24/7.</p>
                    <a href="#"
                        class="inline-block bg-white text-blue-600 px-4 py-2 rounded-lg font-bold text-xs hover:bg-blue-50 transition-colors">
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL BOOKING --}}
    @if ($showBookingModal && $selectedRoom)
        <div class="fixed inset-0 z-[60] flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-md transition-opacity"
                wire:click="closeBookingModal"></div>

            <div
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden animate-entry border border-slate-100">
                <div class="bg-slate-50/80 px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800">Booking Kamar</h3>
                        <p class="text-sm text-blue-600 font-medium">{{ $selectedRoom->name }}</p>
                    </div>
                    <button wire:click="closeBookingModal"
                        class="p-2 bg-white rounded-full shadow-sm text-slate-400 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-8">
                    <livewire:booking-request-form :room="$selectedRoom" />
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-entry {
            animation: cubic-bezier(0.34, 1.56, 0.64, 1) 0.4s forwards slideUp;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</div>
