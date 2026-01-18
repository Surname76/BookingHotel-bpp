<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Booking Hotel</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-neutral-50 text-neutral-900">

{{-- ================= HEADER ================= --}}
<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-2xl">🏨</span>
            <span class="font-bold text-lg">BookingHotel</span>
        </div>

        <nav class="hidden md:flex gap-6 text-sm text-neutral-600">
            <a href="#home" class="hover:text-accent">Home</a>
            <a href="#hotels" class="hover:text-accent">Hotel</a>
            <a href="#" class="hover:text-accent">Contact</a>
        </nav>
    </div>
</header>

{{-- ================= HERO / HOME ================= --}}
<section
    id="home"
    class="relative text-white bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1600&fit=crop');"
>
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/55"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-24">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight drop-shadow-lg">
                Temukan Hotel Terbaik <br>
                di Balikpapan
            </h1>

            <p class="mt-4 text-white/95 drop-shadow">
                Cari dan pilih hotel berdasarkan lokasi, fasilitas,
                dan kenyamanan yang kamu inginkan.
            </p>

            <div class="mt-8 flex gap-4">
                <a href="#hotels"
                   class="bg-white text-accent px-6 py-3 rounded-lg font-semibold
                          hover:opacity-90 shadow-lg">
                    Lihat Hotel
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================= FEATURES ================= --}}
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl border text-center">
            <div class="text-3xl mb-3">📍</div>
            <h3 class="font-semibold mb-1">Lokasi Jelas</h3>
            <p class="text-sm text-neutral-500">
                Cari hotel berdasarkan kecamatan di Balikpapan.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border text-center">
            <div class="text-3xl mb-3">🏨</div>
            <h3 class="font-semibold mb-1">Banyak Pilihan</h3>
            <p class="text-sm text-neutral-500">
                Dari hotel standar hingga premium.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border text-center">
            <div class="text-3xl mb-3">💬</div>
            <h3 class="font-semibold mb-1">Transparan</h3>
            <p class="text-sm text-neutral-500">
                Lihat fasilitas dan ketersediaan sebelum booking.
            </p>
        </div>
    </div>
</section>

{{-- ================= HOTEL LIST ================= --}}
<section id="hotels" class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl font-bold">Hotel Tersedia</h2>
            <p class="text-neutral-500 text-sm">
                Pilih hotel sesuai lokasi dan kebutuhanmu
            </p>
        </div>
    </div>

    {{-- ================= FILTER KECAMATAN ================= --}}
    <section class="mb-10">
        <div class="flex flex-wrap gap-3">
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Kota
            </button>
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Tengah
            </button>
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Barat
            </button>
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Selatan
            </button>
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Utara
            </button>
            <button class="px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition">
                Balikpapan Timur
            </button>
        </div>
    </section>

    {{-- ================= LIST HOTEL ================= --}}
    {{-- NOTE: UNTUK SEMENTARA MASIH PAKAI room-list --}}
    <livewire:room-list />
</section>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-neutral-500 flex flex-col md:flex-row justify-between gap-2">
        <span>© {{ date('Y') }} BookingHotel</span>
        <span>Dibuat dengan Laravel & Tailwind</span>
    </div>
</footer>

@livewireScripts
</body>
</html>
