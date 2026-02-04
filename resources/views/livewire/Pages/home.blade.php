<div>
    {{-- 1. LOADING SCREEN COMPONENT --}}
    {{-- TAMBAHKAN 'wire:ignore' DI SINI --}}
    <div
        id="app-loader"
        wire:ignore
        x-cloak
        x-data="{ show: false }"
        x-init="
            const seen = (() => {
                try { return sessionStorage.getItem('hasVisited'); } catch (e) { return null; }
            })();

            if (seen) {
                show = false;
                $el.classList.add('loaded-hidden');
                return;
            }

            show = true;
        "
        x-show="show"
        class="fixed inset-0 z-[9999] bg-slate-50 flex flex-col items-center justify-center transition-all duration-700 ease-out"
    >
        <div class="text-center space-y-4 relative">
            {{-- Logo Text Animation --}}
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tighter opacity-0 animate-slide-up">
                Booking<span class="text-blue-600">Hotel</span><span class="text-blue-600 animate-pulse">.</span>
            </h1>

            {{-- Modern Loading Indicators --}}
            <div class="flex justify-center gap-2 mt-10">
                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce"></div>
            </div>

            <p class="text-sm text-slate-400 font-medium tracking-widest uppercase mt-4 animate-pulse">Memuat halaman...</p>
        </div>
    </div>

    {{-- 2. KONTEN UTAMA (Existing Code) --}}
    <div class="bg-slate-50 min-h-screen font-sans text-slate-900">

        {{-- Hero Section --}}
        <div class="relative h-[600px] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1600"
                    class="w-full h-full object-cover scale-105 animate-slow-zoom">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/50 to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
                <div class="max-w-2xl text-white space-y-6">
                    <span
                        class="inline-block px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-medium backdrop-blur-md">
                        ✨ Destinasi Terpopuler di Kalimantan Timur
                    </span>
                    <h1 class="text-5xl md:text-6xl font-extrabold leading-[1.1] tracking-tight text-white">
                        Temukan Kenyamanan <br><span class="text-blue-400">Terbaik</span> di Balikpapan
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 leading-relaxed max-w-lg">
                        Bandingkan harga terbaik dari berbagai hotel pilihan. Booking mudah, aman, dan instan tanpa
                        ribet.
                    </p>
                    <div class="flex gap-4 pt-4">
                        <a href="#hotels"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-bold transition-all shadow-xl shadow-blue-600/20 hover:-translate-y-1">
                            Mulai Cari Hotel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section (Floating Cards) --}}
        <div class="max-w-7xl mx-auto px-6 -mt-16 relative z-20">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([['icon' => '🛡️', 'title' => 'Aman & Terpercaya', 'desc' => 'Konfirmasi instan ke sistem hotel.', 'color' => 'blue'], ['icon' => '⚡', 'title' => 'Proses Cepat', 'desc' => 'Booking kurang dari 2 menit saja.', 'color' => 'amber'], ['icon' => '💰', 'title' => 'Harga Terbaik', 'desc' => 'Jaminan harga termurah setiap hari.', 'color' => 'emerald']] as $feature)
                    <div
                        class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/50 flex items-start gap-4 border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                        <div class="bg-{{ $feature['color'] }}-50 p-3 rounded-xl">
                            <span class="text-2xl">{{ $feature['icon'] }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">{{ $feature['title'] }}</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Hotel List Section --}}
        <div id="hotels" class="max-w-7xl mx-auto px-6 py-20">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Rekomendasi Penginapan</h2>
                    <p class="text-slate-500 mt-2 text-lg">Pilih lokasi yang paling sesuai dengan kebutuhanmu.</p>
                </div>
            </div>

            {{-- Filter Buttons --}}
            <div class="flex flex-wrap items-center gap-2 mb-10">
                @foreach (['Semua', 'Kota', 'Selatan', 'Utara', 'Barat', 'Timur', 'Tengah'] as $kec)
                    <button wire:key="filter-{{ $kec }}" wire:click="setFilter('{{ $kec }}')"
                        wire:loading.class="opacity-50 cursor-wait"
                        wire:loading.attr="disabled"
                        class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 border 
                        {{ $filter === $kec
                            ? 'bg-blue-900 text-white border-blue-900 shadow-md shadow-blue-900/20'
                            : 'bg-white text-slate-600 border-slate-200 hover:border-blue-900 hover:text-blue-900' }}">
                        {{ $kec == 'Semua' ? 'Semua Area' : 'Balikpapan ' . $kec }}
                    </button>
                @endforeach
            </div>

            {{-- Hotel Grid --}}
            <div class="relative min-h-[400px]">
                {{-- Loading State - Hanya muncul saat wire:loading dari setFilter --}}
                <div wire:loading.flex wire:target="setFilter"
                    class="hidden absolute inset-0 bg-slate-50/80 backdrop-blur-sm z-20 items-center justify-center rounded-3xl">
                    <div class="flex flex-col items-center gap-3">
                        <div class="animate-spin rounded-full h-10 w-10 border-4 border-slate-200 border-t-blue-600">
                        </div>
                        <span class="text-sm font-semibold text-slate-600 animate-pulse">Memfilter hotel...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($hotels as $hotel)
                        <div
                            class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                            {{-- Image Container (Klik-able) --}}
                            <a href="{{ route('hotels.show', $hotel->id) }}"
                                class="relative h-56 overflow-hidden bg-slate-100 block group/img">
                                @if ($hotel->image_url)
                                    <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Overlay text saat hover gambar --}}
                                <div
                                    class="absolute inset-0 bg-slate-900/0 group-hover/img:bg-slate-900/10 transition-colors duration-300 flex items-center justify-center">
                                    <span
                                        class="text-white opacity-0 group-hover/img:opacity-100 transition-opacity duration-300 bg-slate-900/40 backdrop-blur-sm px-4 py-2 rounded-full text-xs font-bold border border-white/20">
                                        Lihat Detail
                                    </span>
                                </div>

                                {{-- Badge District --}}
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="px-3 py-1 bg-white/90 backdrop-blur text-xs font-bold text-slate-800 rounded-lg shadow-sm">
                                        📍 {{ $hotel->district }}
                                    </span>
                                </div>
                            </a>

                            {{-- Content Body --}}
                            <div class="p-6 flex flex-col flex-1">
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="block">
                                    <h3
                                        class="text-xl font-bold text-slate-900 mb-2 line-clamp-1 group-hover:text-blue-700 transition-colors">
                                        {{ $hotel->name }}
                                    </h3>
                                </a>

                                <p class="text-sm text-slate-500 line-clamp-3 mb-6 flex-1">
                                    {{ $hotel->description ?? 'Deskripsi hotel belum tersedia.' }}
                                </p>

                                {{-- Divider --}}
                                <div class="border-t border-slate-100 my-4"></div>

                                {{-- Price & Action --}}
                                <div class="flex items-end justify-between">
                                    <div>
                                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Mulai dari
                                        </p>
                                        @php
                                            $minPrice = $hotel->rooms->min('price_per_night');
                                        @endphp

                                        @if ($minPrice)
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg font-bold text-blue-600">Rp
                                                    {{ number_format($minPrice, 0, ',', '.') }}</span>
                                                <span class="text-xs text-slate-400">/ malam</span>
                                            </div>
                                        @else
                                            <span class="text-sm font-bold text-red-500">Kamar Penuh</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('hotels.show', $hotel->id) }}"
                                        class="px-4 py-2 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-slate-900/20 text-center">
                                        Lihat Kamar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 py-20 text-center">
                            <div class="inline-block p-6 rounded-full bg-slate-50 mb-4">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Tidak ada hotel ditemukan</h3>
                            <p class="text-slate-500">Coba pilih lokasi lain atau cek kembali nanti.</p>
                        </div>
                    @endforelse
                </div>

                @if ($hotels->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $hotels->onEachSide(1)->fragment('hotels')->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 3. CUSTOM CSS & JAVASCRIPT --}}
    <style>
        @keyframes slow-zoom {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .animate-slow-zoom {
            animation: slow-zoom 20s infinite alternate linear;
        }

        /* Animation untuk Text Reveal */
        @keyframes slideUpFade {
            0% {
                transform: translateY(40px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Class utility untuk menyembunyikan loader */
        .loaded-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>

    <script>
        // Check apakah sudah pernah visit
        const hasVisited = sessionStorage.getItem('hasVisited');
        const loader = document.getElementById('app-loader');
        
        if (!hasVisited && loader) {
            // First visit - tampilkan loader
            loader.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            // Hide setelah 1 detik
            setTimeout(function() {
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
                document.body.style.overflow = '';

                sessionStorage.setItem('hasVisited', 'true');
            };

            // 1. Cek apakah user sudah pernah melihat animasi ini di sesi ini
            if (sessionStorage.getItem('hasVisited')) {
                // Jika sudah, langsung sembunyikan loader tanpa animasi
                if (loader) loader.classList.add('loaded-hidden');
                return; // Hentikan eksekusi script selanjutnya
            }

            // 2. Jika belum pernah, jalankan logika animasi

            // Matikan Scroll saat awal loading
            document.body.style.overflow = 'hidden';

            // Jangan paksa loading terlalu lama (biar terasa cepat).
            // Penting: pada Livewire navigate, event `window.load` tidak selalu terpanggil.
            const minimumLoadingTime = 300;
            const startTime = Date.now();

            // Fallback: selalu tutup loader walau `load` tidak terpanggil.
            setTimeout(hideLoader, minimumLoadingTime + 300);

            window.addEventListener('load', function() {
                const elapsedTime = Date.now() - startTime;
                const remainingTime = Math.max(0, minimumLoadingTime - elapsedTime);

                setTimeout(hideLoader, remainingTime);
            });

            // Livewire SPA navigation events (biar loader gak stuck)
            document.addEventListener('livewire:navigated', hideLoader);
        });
    </script>
</div>