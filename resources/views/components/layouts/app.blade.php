<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookingHotel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-slate-50 font-sans text-slate-900 flex flex-col min-h-screen">

    {{-- NAVBAR ADMIN (Hanya muncul jika login) --}}
    @auth
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        {{-- Ganti route ke dashboard atau home sesuai kebutuhan --}}
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-xl text-slate-800">
                            <div class="w-8 h-8 rounded-lg bg-blue-900 flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <span>AdminPanel</span>
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        {{-- Link Home (Frontend) --}}
                        <a href="/" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 ease-in-out border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                            Home
                        </a>

                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 ease-in-out
                           {{ request()->routeIs('admin.dashboard') ? 'border-blue-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.booking-requests') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 ease-in-out
                           {{ request()->routeIs('admin.booking-requests') ? 'border-blue-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Booking Requests
                        </a>

                        <a href="{{ route('admin.manage-hotels') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-150 ease-in-out
                           {{ request()->routeIs('admin.manage-hotels') ? 'border-blue-900 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                            Manage Hotels
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-600">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                        
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors p-2 rounded-full hover:bg-slate-100" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="-mr-2 flex items-center sm:hidden">
                    <button class="text-slate-500 hover:text-slate-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    {{-- MAIN CONTENT --}}
    {{-- Flex-1 memastikan footer terdorong ke bawah jika konten sedikit --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

{{-- CLEAN & PROFESSIONAL FOOTER --}}
<footer class="bg-slate-900 text-slate-400 border-t border-slate-800 font-sans">
    <div class="max-w-7xl mx-auto px-6 pt-16 pb-8">
        
        {{-- Top Section: Grid Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-12">
            
            {{-- 1. BRAND IDENTITY (Lebar: 4 kolom) --}}
            <div class="lg:col-span-4 space-y-4">
                <a href="/" class="flex items-center gap-2.5 font-bold text-xl text-white">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white shadow-lg shadow-blue-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </div>
                    <span>BookingHotel</span>
                </a>
                <p class="text-sm leading-relaxed text-slate-500 max-w-xs">
                    Mitra perjalanan terbaik Anda di Kalimantan Timur. Booking mudah, harga transparan, liburan tenang.
                </p>
            </div>

            {{-- 2. NAVIGATION (Lebar: 2 kolom) --}}
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-5">Menu</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="/" class="hover:text-blue-400 transition-colors duration-200">Beranda</a></li>
                    <li><a href="#hotels" class="hover:text-blue-400 transition-colors duration-200">Cari Hotel</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition-colors duration-200">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- 3. SUPPORT (Lebar: 2 kolom) --}}
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-5">Bantuan</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('help-center') }}" class="hover:text-blue-400 transition-colors duration-200">Pusat Bantuan</a></li>
                    <li><a href="{{ route('privacy-policy') }}" class="hover:text-blue-400 transition-colors duration-200">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('terms-and-conditions') }}" class="hover:text-blue-400 transition-colors duration-200">Syarat Ketentuan</a></li>
                </ul>
            </div>

            {{-- 4. NEWSLETTER (Lebar: 4 kolom) --}}
            <div class="lg:col-span-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-5">Info Promo</h3>
                <form class="flex flex-col gap-3">
                    <div class="relative">
                        <input type="email" placeholder="Masukkan email Anda" 
                            class="w-full bg-slate-800/50 border border-slate-700 text-slate-200 text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-600">
                        <button type="button" class="absolute right-1.5 top-1.5 bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-lg transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-600">Kami tidak akan mengirimkan spam.</p>
                </form>
            </div>
        </div>

        {{-- Bottom Section: Copyright & Socials --}}
        <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-600">
                &copy; {{ date('Y') }} BookingHotel Corp. All rights reserved.
            </p>
            
            <div class="flex items-center gap-5">
                <a href="#" class="text-slate-500 hover:text-white transition-colors"><span class="sr-only">Instagram</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="#" class="text-slate-500 hover:text-white transition-colors"><span class="sr-only">Twitter</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>

    @livewireScripts
</body>
</html>