<div>
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Daftar Hotel --}}
    @if ($rooms->isEmpty())
        <div class="bg-white border rounded-xl p-8 text-center text-neutral-500">
            Tidak ada hotel tersedia saat ini.
        </div>
    @else
        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($rooms as $hotel)

                {{-- CARD HOTEL --}}
                <a
                    href="{{ route('hotels.show', $hotel->id) }}"
                    wire:navigate
                    class="group bg-white border rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col"
                >

                    {{-- IMAGE --}}
                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ $hotel->image_url ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&fit=crop' }}"
                            alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        />

                        {{-- BADGE KECAMATAN --}}
                        @if (!empty($hotel->district))
                            <div class="absolute top-3 left-3 bg-black/60 text-white text-xs px-3 py-1 rounded-full">
                                {{ $hotel->district }}
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-lg text-neutral-800 mb-1">
                            {{ $hotel->name }}

                        </h3>

                        <p class="text-sm text-neutral-500 line-clamp-2">
                            {{ $hotel->description ?? 'Hotel nyaman dengan fasilitas lengkap di Balikpapan.' }}
                        </p>

                        {{-- CTA --}}
                        <div class="mt-auto pt-4 text-sm font-medium text-accent">
                            Lihat Hotel →
                        </div>
                    </div>

                </a>

            @endforeach
        </div>
    @endif
</div>
