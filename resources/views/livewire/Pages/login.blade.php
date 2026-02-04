<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] px-6 py-12">
    <div class="w-full max-w-md">
        {{-- Card Utama --}}
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
            
            {{-- Header Section --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-3xl mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h1>
                <p class="mt-3 text-sm text-slate-500 font-medium px-4">
                    Masuk untuk akses cepat ke booking kamar dan riwayat pesanan Anda.
                </p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-50 border border-rose-100 p-4 text-xs font-bold text-rose-700 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-6">
                {{-- Email Field --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Alamat Email</label>
                    <div class="relative">
                        <input
                            type="email"
                            wire:model.defer="email"
                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                            placeholder="nama@email.com"
                            required
                        />
                    </div>
                    @error('email') <p class="mt-2 text-[10px] font-bold text-rose-600 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <div class="flex justify-between items-end mb-2 ml-1">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Kata Sandi</label>
                        {{-- Opsi: Tambahkan link 'Lupa Password' di sini jika ada fungsinya nanti --}}
                    </div>
                    <input
                        type="password"
                        wire:model.defer="password"
                        class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                        placeholder="••••••••"
                        required
                    />
                    @error('password') <p class="mt-2 text-[10px] font-bold text-rose-600 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" wire:model="remember" class="w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-600/20 transition-all cursor-pointer" />
                        <span class="text-sm font-bold text-slate-600 group-hover:text-slate-900 transition-colors">Ingat saya</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-black uppercase tracking-[0.2em] py-5 shadow-xl shadow-blue-900/10 transition-all active:scale-[0.98] flex items-center justify-center gap-3"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="submit">Masuk ke Akun</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="inline-block ml-1 font-black text-blue-600 hover:text-blue-700 hover:underline decoration-2 underline-offset-4 transition-all">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>
        
        {{-- Link Kembali ke Home --}}
        <div class="text-center mt-8">
            <a href="/" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>