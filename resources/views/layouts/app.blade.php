<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'BookingHotel' }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

@if (session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

<body class="bg-neutral-50 text-neutral-900">

<header class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl">🏨</span>
            <span class="font-bold text-lg">BookingHotel</span>
        </a>

        <nav class="flex gap-6 text-sm text-neutral-600">
            <a href="/" class="hover:text-accent">Home</a>
            <a href="/#rooms" class="hover:text-accent">Hotel</a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="/admin/dashboard" class="hover:text-accent font-semibold">
                        Dashboard
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
