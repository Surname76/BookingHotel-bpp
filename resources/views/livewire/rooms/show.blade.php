<div class="bg-neutral-50 text-neutral-900">

    {{-- ================= HERO HOTEL ================= --}}
    <section class="relative h-[60vh] bg-black">
        <img src="{{ $room->image_url ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&fit=crop' }}"
            alt="{{ $room->name }}" class="w-full h-full object-cover opacity-80" />

        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-6 pb-10 text-white">
                <span class="inline-block bg-black/60 text-sm px-3 py-1 rounded-full mb-3">
                    {{ $room->district ?? 'Balikpapan Utara' }}
                </span>

                <h1 class="text-3xl md:text-4xl font-bold drop-shadow-lg">
                    {{ $room->name ?? 'Hotel Nova Balikpapan' }}
                </h1>

                <p class="mt-2 text-white/90 max-w-2xl">
                    Hotel nyaman di pusat kota dengan akses mudah ke berbagai fasilitas umum.
                </p>
            </div>
        </div>
    </section>

    {{-- ================= CONTENT ================= --}}
    <section class="max-w-7xl mx-auto px-6 py-12 grid lg:grid-cols-3 gap-10">

        {{-- ===== LEFT CONTENT ===== --}}
        <div class="lg:col-span-2 space-y-12">

            {{-- DESKRIPSI HOTEL --}}
            <div>
                <h2 class="text-xl font-semibold mb-3">Tentang Hotel</h2>
                <p class="text-neutral-600 leading-relaxed">
                    {{ $room->description ?? 'Hotel ini menawarkan berbagai kelas kamar yang dapat dipilih sesuai kebutuhan bisnis maupun liburan Anda.' }}
                </p>
            </div>

            {{-- ================= FASILITAS HOTEL ================= --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Fasilitas Hotel</h2>

                <ul class="grid sm:grid-cols-2 gap-3 text-neutral-700 text-sm">
                    <li>📶 Wifi Gratis</li>
                    <li>🏊 Kolam Renang</li>
                    <li>🍳 Restoran</li>
                    <li>📺 TV</li>
                    <li>❄️ AC</li>
                </ul>

                <details class="group mt-4">
                    <summary class="cursor-pointer text-accent text-sm font-medium hover:underline list-none">
                        <span class="group-open:hidden">Lihat semua fasilitas</span>
                        <span class="hidden group-open:inline">Sembunyikan fasilitas</span>
                    </summary>

                    <div class="mt-4 grid md:grid-cols-2 gap-8">
                        <ul class="space-y-2 text-sm text-neutral-600">
                            <li>🚗 Area parkir</li>
                            <li>🏋️ Pusat kebugaran</li>
                            <li>🩹 P3K</li>
                            <li>🚨 Alarm asap</li>
                        </ul>
                        <ul class="space-y-2 text-sm text-neutral-400">
                            <li>❌ Mesin cuci</li>
                            <li>❌ Pengering rambut</li>
                            <li>❌ Pemanas ruangan</li>
                        </ul>
                    </div>
                </details>
            </div>

            {{-- ================= GALERI ================= --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Galeri Hotel</h2>

                <div class="grid grid-cols-3 gap-3">
                    @for ($i = 0; $i < 3; $i++)
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&fit=crop"
                            class="rounded-lg object-cover h-32 w-full" alt="Galeri hotel" />
                    @endfor
                </div>
            </div>

        </div>

        {{-- ===== RIGHT SIDEBAR ===== --}}
        <div class="bg-white border rounded-xl p-6 h-fit sticky top-24">
            <h3 class="font-semibold mb-2">Lokasi</h3>
            <p class="text-sm text-neutral-600">
                {{ $room->district ?? 'Balikpapan Utara' }}, Kalimantan Timur
            </p>

            {{-- BUTTON OPEN MODAL --}}
            <a href="#availability-modal"
                class="mt-4 block text-center bg-accent text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                Lihat Kamar Tersedia
            </a>
        </div>

    </section>

    {{-- ================= MODAL KETERSEDIAAN ================= --}}
    <div id="availability-modal" class="fixed inset-0 bg-black/50 z-50 hidden target:block">

        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6 relative">

                {{-- CLOSE --}}
                <a href="#" class="absolute top-4 right-4 text-neutral-400 hover:text-neutral-600">
                    ✕
                </a>

                {{-- LIVEWIRE BOOKING REQUEST (2 STEP) --}}
                <livewire:booking-request-form :room="$room" />

            </div>
        </div>
    </div>

</div>
