<div class="space-y-8">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm animate-fade-in-down">
            <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-bold tracking-wide">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Daftar Hotel --}}
    @if ($rooms->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white border border-dashed border-gray-300 rounded-[2rem] text-center">
            <div class="bg-gray-50 p-6 rounded-full mb-4 text-4xl">🏨</div>
            <h3 class="text-xl font-bold text-gray-900">Belum Ada Kamar Tersedia</h3>
            <p class="text-neutral-500 mt-2 max-w-xs">Kami tidak dapat menemukan hotel di area ini. Silakan coba filter area lain.</p>
        </div>
    @else
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($rooms as $hotel)
                {{-- CARD HOTEL --}}
                <div class="group bg-white rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500 flex flex-col border border-gray-100 relative">
                    
                    {{-- IMAGE SECTION --}}
                    <div class="relative h-64 overflow-hidden">
                        <img
                            src="{{ $hotel->image_url ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&fit=crop' }}"
                            alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out"
                        />
                        
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        {{-- BADGE AREA --}}
                        @if (!empty($hotel->district))
                            <div class="absolute top-4 left-4 backdrop-blur-md bg-white/80 text-blue-600 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-sm">
                                📍 {{ $hotel->district }}
                            </div>
                        @endif

                        {{-- WISHLIST BUTTON (Optional Visual) --}}
                        <button class="absolute top-4 right-4 p-2.5 rounded-xl bg-white/20 backdrop-blur-md text-white hover:bg-white hover:text-red-500 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                        </button>
                    </div>

                    {{-- CONTENT SECTION --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-black text-xl text-gray-900 leading-tight group-hover:text-blue-600 transition-colors">
                                {{ $hotel->name }}
                            </h3>
                        </div>

                        {{-- RATING & FACILITIES --}}
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex text-amber-400 text-xs">
                                ★★★★☆ <span class="ml-1 text-gray-400 font-bold">(4.8)</span>
                            </div>
                            <span class="text-gray-300">|</span>
                            <div class="flex gap-2 text-gray-400">
                                <span title="Wifi Gratis">📶</span>
                                <span title="Kolam Renang">🏊</span>
                            </div>
                        </div>

                        <p class="text-sm text-neutral-500 line-clamp-2 leading-relaxed mb-6">
                            {{ $hotel->description ?? 'Nikmati pengalaman menginap tak terlupakan dengan pelayanan bintang lima di jantung kota Balikpapan.' }}
                        </p>

                        {{-- PRICE & ACTION --}}
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Mulai dari</p>
                                <p class="text-xl font-black text-blue-600">
                                    Rp {{ number_format($hotel->price ?? 450000, 0, ',', '.') }}<span class="text-xs text-gray-400 font-normal">/malam</span>
                                </p>
                            </div>
                            
                            <a 
                                href="{{ route('hotels.show', $hotel->id) }}" 
                                wire:navigate
                                class="bg-gray-900 text-white p-4 rounded-2xl group-hover:bg-blue-600 transition-all duration-300 shadow-xl shadow-gray-200 group-hover:shadow-blue-200"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>
</div>
