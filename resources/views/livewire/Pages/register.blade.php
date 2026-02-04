<div class="min-h-screen flex items-center justify-center bg-[#f8fafc] px-6 py-12">
    <div class="w-full max-w-xl"> {{-- max-w-xl agar sedikit lebih lebar dari login --}}
        {{-- Card Utama --}}
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.05)]">
            
            {{-- Header Section --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-3xl mb-4 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Akun</h1>
                <p class="mt-3 text-sm text-slate-500 font-medium px-4">
                    Gabung bersama kami untuk pengalaman booking hotel yang lebih mudah dan cepat.
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

            <form wire:submit.prevent="submit" class="space-y-5">
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Nama Lengkap</label>
                    <input
                        type="text"
                        wire:model.defer="name"
                        class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                        placeholder="Masukkan nama sesuai KTP"
                        required
                    />
                    @error('name') <p class="mt-2 text-[10px] font-bold text-rose-600 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Alamat Email</label>
                    <input
                        type="email"
                        wire:model.defer="email"
                        class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                        placeholder="nama@email.com"
                        required
                    />
                    @error('email') <p class="mt-2 text-[10px] font-bold text-rose-600 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                </div>

                {{-- Row Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Password</label>
                        <input
                            type="password"
                            wire:model.defer="password"
                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                            placeholder="Min. 8 karakter"
                            required
                        />
                        @error('password') <p class="mt-2 text-[10px] font-bold text-rose-600 ml-1 uppercase tracking-wider">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-2 ml-1">Konfirmasi</label>
                        <input
                            type="password"
                            wire:model.defer="password_confirmation"
                            class="w-full rounded-2xl border-none bg-slate-50 px-5 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none placeholder-slate-300"
                            placeholder="Ulangi password"
                            required
                        />
                    </div>
                </div>

                {{-- Term & Condition (Opsional tapi bagus untuk visual) --}}
                {{-- <div class="px-1 py-2">
                    <p class="text-[11px] text-slate-400 leading-relaxed font-medium">
                        Dengan mendaftar, Anda menyetujui <a href="#" class="text-blue-600 font-bold">Syarat & Ketentuan</a> serta <a href="#" class="text-blue-600 font-bold">Kebijakan Privasi</a> kami.
                    </p>
                </div> --}}

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-black uppercase tracking-[0.2em] py-5 shadow-xl shadow-blue-900/10 transition-all active:scale-[0.98] flex items-center justify-center gap-3"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="submit">Buat Akun Sekarang</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mendaftarkan...
                    </span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="inline-block ml-1 font-black text-blue-600 hover:text-blue-700 hover:underline decoration-2 underline-offset-4 transition-all">
                        Masuk Disini
                    </a>
                </p>
            </div>
        </div>
        
        {{-- Kembali ke Home --}}
        <div class="text-center mt-8">
            <a href="/" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>