<div class="space-y-6">
    @if (session()->has('message'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 flex items-center justify-between shadow-sm"
        >
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-bold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2"></path>
                </svg>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
            <p class="text-xs font-bold uppercase tracking-wider mb-2">Mohon periksa data berikut:</p>
            <ul class="list-disc list-inside text-sm space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- KOLOM KIRI: RINGKASAN --}}
        <div class="lg:col-span-4 space-y-4 order-2 lg:order-1">
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Ringkasan Pesanan</p>

                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-slate-500 shrink-0">Hotel</span>
                        <span class="font-bold text-slate-900 text-right truncate">{{ $room->hotel?->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-slate-500 shrink-0">Kamar</span>
                        <span class="font-bold text-slate-900 text-right truncate">{{ $room->name }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-slate-500 shrink-0">Harga / malam</span>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format((float) $room->price_per_night, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-slate-500 shrink-0">Durasi</span>
                        <span class="font-bold text-slate-900">
                            {{ $totalNights ? $totalNights.' malam' : '-' }}
                        </span>
                    </div>
                    <div class="pt-4 border-t border-dashed border-slate-300 flex justify-between items-center gap-4">
                        <span class="text-sm font-black text-slate-900 uppercase">Total</span>
                        <span class="text-xl font-black text-blue-600 text-right">
                            {{ $estimatedAmount ? 'Rp '.number_format((float) $estimatedAmount, 0, ',', '.') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-bold text-slate-900">Info</p>
                <p class="text-xs text-slate-600 mt-1">
                    Total di atas adalah estimasi berdasarkan tanggal menginap dan harga per malam.
                </p>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM --}}
        <div class="lg:col-span-8 order-1 lg:order-2">
            @guest
                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-6 text-amber-800">
                    <p class="text-sm font-extrabold">Silakan login untuk melanjutkan booking request.</p>
                    <p class="text-xs mt-1 text-amber-700">Setelah login, isi data tamu dan tanggal menginap.</p>
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-sm font-semibold">
                        <a href="{{ route('login') }}" class="text-blue-700 hover:text-blue-800 underline">Login</a>
                        <span class="text-amber-300">|</span>
                        <a href="{{ route('register') }}" class="text-slate-700 hover:text-slate-900 underline">Daftar</a>
                    </div>
                </div>
            @endguest

            @auth
                <form wire:submit.prevent="submit" class="space-y-6">
                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Data Tamu</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Nama Lengkap</label>
                                <input
                                    type="text"
                                    wire:model.defer="guest_name"
                                    autocomplete="name"
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none"
                                >
                                @error('guest_name')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">Email</label>
                                <input
                                    type="email"
                                    wire:model.defer="guest_email"
                                    autocomplete="email"
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none"
                                >
                                @error('guest_email')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 ml-1">No. WhatsApp (opsional)</label>
                                <input
                                    type="tel"
                                    wire:model.defer="guest_phone"
                                    autocomplete="tel"
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none"
                                >
                                @error('guest_phone')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Jadwal</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Check-in</label>
                                <input
                                    type="date"
                                    wire:model.live="check_in"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 p-2 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-600/5"
                                >
                                @error('check_in')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jam</label>
                                <input
                                    type="time"
                                    wire:model.defer="check_in_time"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 p-2 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-600/5"
                                >
                                @error('check_in_time')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Check-out</label>
                                <input
                                    type="date"
                                    wire:model.live="check_out"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 p-2 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-600/5"
                                >
                                @error('check_out')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jam</label>
                                <input
                                    type="time"
                                    wire:model.defer="check_out_time"
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 p-2 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-600/5"
                                >
                                @error('check_out_time')
                                    <p class="mt-1 text-[10px] font-bold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Permintaan Khusus (opsional)</h4>
                        <textarea
                            wire:model.defer="special_request"
                            rows="3"
                            placeholder="Permintaan khusus..."
                            class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="w-full bg-slate-900 hover:bg-blue-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl transition-all flex items-center justify-center gap-3"
                    >
                        <span wire:loading.remove wire:target="submit">Lanjut ke Pembayaran</span>
                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Memproses...
                        </span>
                    </button>

                    <p class="text-xs text-slate-500 text-center">
                        Setelah submit, kamu akan diarahkan ke halaman pembayaran Xendit.
                    </p>
                </form>
            @endauth
        </div>
    </div>
</div>
