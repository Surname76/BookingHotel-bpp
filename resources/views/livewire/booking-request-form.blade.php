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

                    @if($subtotal > 0)
                        <div class="pt-3 border-t border-dashed border-slate-300">
                            <div class="flex justify-between items-center text-sm gap-4">
                                <span class="text-slate-500 shrink-0">Subtotal</span>
                                <span class="font-bold text-slate-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        @if($totalDiscount > 0)
                            <div class="bg-green-50 -mx-6 px-6 py-3 border-y border-green-100">
                                <div class="flex justify-between items-center text-sm gap-4">
                                    <span class="text-green-700 shrink-0 font-semibold">Total Diskon</span>
                                    <span class="font-bold text-green-600">
                                        - Rp {{ number_format($totalDiscount, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                @if(!empty($appliedDiscountsData))
                                    <div class="mt-2 space-y-1">
                                        @foreach($appliedDiscountsData as $discount)
                                            <div class="flex items-center gap-2 text-xs text-green-700">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>{{ $discount['name'] }}</span>
                                                <span class="ml-auto font-semibold">-Rp {{ number_format($discount['amount'], 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                    
                    <div class="pt-4 border-t border-dashed border-slate-300 flex justify-between items-center gap-4">
                        <span class="text-sm font-black text-slate-900 uppercase">Total</span>
                        <span class="text-xl font-black {{ $totalDiscount > 0 ? 'text-green-600' : 'text-blue-600' }} text-right">
                            {{ $estimatedAmount ? 'Rp '.number_format((float) $estimatedAmount, 0, ',', '.') : '-' }}
                        </span>
                    </div>

                    @if($totalDiscount > 0)
                        <div class="pt-2 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                Hemat Rp {{ number_format($totalDiscount, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-bold text-slate-900">Info</p>
                <p class="text-xs text-slate-600 mt-1">
                    Total di atas {{ $totalDiscount > 0 ? 'sudah termasuk diskon yang berlaku' : 'adalah estimasi berdasarkan tanggal menginap dan harga per malam' }}.
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

                    {{-- PROMO & VOUCHER SECTION --}}
                    @if($check_in && $check_out)
                        {{-- Available Discounts --}}
                        @if($availableDiscounts->count() > 0)
                            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                    </svg>
                                    Promo Tersedia
                                </h4>
                                
                                <div class="space-y-3">
                                    @foreach($availableDiscounts as $discount)
                                        <label class="flex items-start gap-3 p-4 border-2 rounded-2xl cursor-pointer transition-all {{ in_array($discount->id, $selectedDiscounts) ? 'border-blue-600 bg-blue-50' : 'border-slate-200 hover:border-blue-300 hover:bg-blue-50/30' }}">
                                            <input type="checkbox" 
                                                wire:click="toggleDiscount({{ $discount->id }})" 
                                                {{ in_array($discount->id, $selectedDiscounts) ? 'checked' : '' }}
                                                class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                            
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between gap-2">
                                                    <div>
                                                        <div class="font-bold text-slate-900">{{ $discount->name }}</div>
                                                        @if($discount->description)
                                                            <p class="text-xs text-slate-600 mt-1">{{ $discount->description }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-lg font-black text-blue-600">
                                                            @if($discount->discount_type === 'percentage')
                                                                {{ $discount->discount_value }}%
                                                            @else
                                                                Rp {{ number_format($discount->discount_value, 0, ',', '.') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    <span class="px-2 py-1 text-[10px] font-bold rounded-full uppercase
                                                        @if($discount->type === 'room_type') bg-purple-100 text-purple-700
                                                        @elseif($discount->type === 'extended_stay') bg-blue-100 text-blue-700
                                                        @elseif($discount->type === 'weekday') bg-green-100 text-green-700
                                                        @elseif($discount->type === 'seasonal') bg-orange-100 text-orange-700
                                                        @else bg-pink-100 text-pink-700
                                                        @endif">
                                                        {{ str_replace('_', ' ', $discount->type) }}
                                                    </span>
                                                    
                                                    @if($discount->min_nights)
                                                        <span class="px-2 py-1 text-[10px] font-bold bg-slate-100 text-slate-700 rounded-full uppercase">
                                                            Min. {{ $discount->min_nights }} malam
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Voucher Code --}}
                        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Punya Kode Voucher?
                            </h4>

                            @if($appliedVoucher)
                                {{-- Applied Voucher --}}
                                <div class="p-4 bg-green-50 border-2 border-green-200 rounded-2xl">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-green-900">{{ $appliedVoucher->name }}</div>
                                                <code class="text-sm text-green-700 font-mono font-bold">{{ $appliedVoucher->code }}</code>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="removeVoucher" class="text-green-600 hover:text-green-800 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                {{-- Voucher Input --}}
                                <div class="flex gap-2">
                                    <input type="text" wire:model="voucherCode" 
                                        placeholder="Masukkan kode voucher"
                                        class="flex-1 rounded-2xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-mono uppercase focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all outline-none @error('voucherCode') border-red-500 @enderror">
                                    <button type="button" wire:click="applyVoucher" 
                                        class="px-6 py-3 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs transition-all">
                                        Terapkan
                                    </button>
                                </div>
                                
                                @if($voucherError)
                                    <p class="text-xs text-rose-600 mt-2 flex items-center gap-1 font-bold ml-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $voucherError }}
                                    </p>
                                @endif

                                @if(session()->has('voucher_success'))
                                    <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-bold ml-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ session('voucher_success') }}
                                    </p>
                                @endif
                            @endif
                        </div>
                    @endif

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