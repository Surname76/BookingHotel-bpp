<div
    x-data="{
        atTop: true,
        isHome: window.location.pathname === '/',
        logoutOpen: false,
        scrollToTop(e) {
            if (this.isHome) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }"
>
    {{-- CSS STYLE --}}
    <style>
        /* ROLLING TEXT ANIMATION */
        .ease-fluid { transition-timing-function: cubic-bezier(0.76, 0, 0.24, 1); }
        [x-cloak] { display: none !important; }
        
        .link-roll-container {
            height: 1.5em;
            overflow: hidden;
            position: relative;
            display: inline-block;
        }
        
        .link-roll-text {
            display: block;
            transition: transform 0.5s cubic-bezier(0.76, 0, 0.24, 1);
        }
        
        .group:hover .link-roll-text { transform: translateY(-100%); }
    </style>

    {{-- 
        PERUBAHAN UTAMA:
        1. Ganti 'sticky' -> 'fixed'
        2. Tambah 'inset-x-0' (agar lebar penuh kiri-kanan)
    --}}
    <nav
        @scroll.window="atTop = (window.pageYOffset < 20)"
        :class="{ 'bg-white/90 backdrop-blur-xl border-slate-200/60 shadow-sm': !atTop, 'bg-white/80 backdrop-blur-md border-transparent': atTop }"
        class="fixed top-0 inset-x-0 z-50 w-full border-b transition-all duration-300 ease-fluid"
    >
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            
            {{-- 1. LOGO BRAND --}}
            <a href="/" wire:navigate @click="scrollToTop($event)" class="flex items-center gap-2.5 group select-none cursor-pointer">
                <div class="bg-slate-900 text-white p-2 rounded-xl group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500 ease-fluid shadow-lg shadow-slate-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10h.01M9 17h.01M9 14h.01M12 17h.01M12 14h.01M15 17h.01M15 14h.01M12 11h.01M12 7h.01M15 11h.01M15 7h.01"></path></svg>
                </div>
                <span class="font-black text-xl tracking-tight uppercase text-slate-800">
                    Book<span class="text-blue-600">In</span>
                </span>
            </a>

            {{-- 2. CENTER MENU --}}
            <div class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/50 backdrop-blur-sm">
                
                @foreach([
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Hotels', 'url' => '/#hotels'],
                    ['label' => 'Promotion', 'url' => '#'],
                ] as $link)
                    <a href="{{ $link['url'] }}" 
                       @if($link['url'] == '/') wire:navigate @click="scrollToTop($event)" @endif
                       class="group px-6 py-2.5 rounded-full hover:bg-white hover:shadow-sm transition-all duration-300 ease-fluid relative overflow-hidden">
                        <div class="link-roll-container text-xs font-bold uppercase tracking-widest text-slate-500">
                            <span class="link-roll-text group-hover:text-slate-900">{{ $link['label'] }}</span>
                            <span class="link-roll-text absolute top-full left-0 text-blue-600">{{ $link['label'] }}</span>
                        </div>
                    </a>
                @endforeach

            </div>

            {{-- 3. AUTH BUTTONS --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('bookings.history') }}" wire:navigate class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-blue-600 transition-colors duration-300">
                        Riwayat
                    </a>

                    @if (auth()->user()?->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-xs font-black uppercase tracking-wider text-blue-700 hover:text-blue-800 transition-colors duration-300">
                            Admin Panel
                        </a>
                    @endif
                    
                    <form x-ref="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>

                    <button type="button" @click="logoutOpen = true"
                        class="group relative overflow-hidden px-6 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:shadow-lg transition-all duration-500 ease-fluid">
                        <span class="relative z-10">Logout</span>
                        <div class="absolute inset-0 bg-red-600 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-fluid"></div>
                    </button>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-blue-600 transition-colors duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" wire:navigate class="group relative overflow-hidden px-7 py-3 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-blue-500/30 hover:shadow-blue-600/50 hover:scale-105 transition-all duration-500 ease-fluid">
                        <span class="relative z-10 group-hover:text-white transition-colors">Register</span>
                        <div class="absolute inset-0 bg-slate-900 transform scale-x-0 origin-left group-hover:scale-x-100 transition-transform duration-500 ease-fluid"></div>
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    {{-- LOGOUT CONFIRM MODAL --}}
    <div
        x-cloak
        x-show="logoutOpen"
        x-transition.opacity
        class="fixed inset-0 z-[70] flex items-center justify-center px-4"
        @keydown.escape.window="logoutOpen = false"
    >
        <button type="button" class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm" @click="logoutOpen = false" aria-label="Tutup"></button>

        <div
            x-show="logoutOpen"
            x-transition
            class="w-full max-w-md rounded-3xl bg-white border border-slate-200 shadow-2xl overflow-hidden relative z-10"
            role="dialog"
            aria-modal="true"
            aria-labelledby="logout-title"
        >
            <div class="p-6 sm:p-7">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 id="logout-title" class="text-lg font-black text-slate-900 tracking-tight">Konfirmasi Logout</h3>
                        <p class="text-sm text-slate-500 mt-1">Kamu yakin ingin keluar dari akun ini?</p>
                    </div>
                    <button type="button" @click="logoutOpen = false" class="p-2 rounded-full text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="logoutOpen = false"
                        class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 bg-white text-slate-700 text-sm font-bold hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="button" @click="$refs.logoutForm.submit()"
                        class="flex-1 px-4 py-3 rounded-2xl bg-red-600 text-white text-sm font-black hover:bg-red-700 transition shadow-lg shadow-red-600/20">
                        Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
