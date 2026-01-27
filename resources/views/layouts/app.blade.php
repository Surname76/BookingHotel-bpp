<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BookIn | Hotel Booking' }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-neutral-50 text-neutral-900 font-sans antialiased">

    {{-- ================= NAVBAR ================= --}}
    <livewire:navbar />

    <main>
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-neutral-900 text-neutral-400 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-xl font-black text-white uppercase tracking-tighter">Book<span class="text-blue-500">In</span></span>
            <p class="mt-4 text-sm">&copy; {{ date('Y') }} Booking Hotel Balikpapan. All rights reserved.</p>
        </div>
    </footer>

    <nav class="flex gap-6 text-sm text-neutral-600">
        <a href="/" class="hover:text-accent">Home</a>
        <a href="/#rooms" class="hover:text-accent">Hotel</a>

        @auth
        @if(auth()->user()->is_admin)
        <a href="/admin/dashboard" class="hover:text-accent font-semibold">
            Dashboard
        </a>
        <a href="/admin/manage-hotels" class="hover:text-accent font-semibold">
            Manage-Hotels
        </a>
        @endif
        @endauth
    </nav>
    </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t mt-20">
        <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-neutral-500 flex justify-between">
            <span>© {{ date('Y') }} BookingHotel</span>
            <span>Dibuat dengan Laravel & Tailwind</span>
        </div>
    </footer>

    @livewireScripts
</body>

</html>