<div class="p-6 bg-white rounded-2xl">
    {{-- ALERT BERHASIL (Menggunakan Alpine.js untuk animasi otomatis hilang) --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-bold">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"></path></svg>
            </button>
        </div>
    @endif

    {{-- ALERT ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl">
            <p class="text-xs font-bold uppercase tracking-wider mb-2">Mohon lengkapi data:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STEP 1: PILIH KELAS --}}
    @if ($step === 'select')
    <h2 class="text-xl font-bold text-slate-900 mb-6 tracking-tight">Pilih Kelas Kamar</h2>
    <div class="space-y-4">
        @foreach ($roomTypes as $type)
        <div class="group border border-slate-200 rounded-2xl p-5 flex justify-between items-center hover:border-indigo-600 transition-all">
            <div>
                <h3 class="font-bold text-slate-800 text-lg group-hover:text-indigo-600 transition-colors">{{ $type->name }}</h3>
                <p class="text-sm text-slate-500">{{ $type->description }}</p>
                <p class="font-black text-indigo-600 mt-2">
                    Rp {{ number_format($type->price_per_night, 0, ',', '.') }} <span class="text-xs text-slate-400 font-normal">/ malam</span>
                </p>
            </div>
            <button type="button" wire:click="chooseType({{ $type->id }})"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all active:scale-95">
                Pilih
            </button>
        </div>
        @endforeach
    </div>
    @endif

    {{-- STEP 2: BENEFIT --}}
    @if ($step === 'benefit' && $selectedType)
    <button type="button" wire:click="back" class="text-xs font-bold text-slate-400 hover:text-indigo-600 mb-4 flex items-center gap-1 uppercase tracking-widest">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3"></path></svg> 
        Kembali
    </button>
    <h2 class="text-xl font-bold text-slate-900 mb-4">Mengapa memilih {{ $selectedType->name }}?</h2>
    <ul class="space-y-3 mb-8 bg-slate-50 p-6 rounded-2xl border border-slate-100">
        @foreach ($selectedType->benefits ?? [] as $benefit)
        <li class="flex items-center gap-3 text-sm text-slate-700 font-medium">
            <span class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-[10px]">✔</span>
            <span>{{ $benefit }}</span>
        </li>
        @endforeach
    </ul>
    <button type="button" wire:click="proceedToForm" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold shadow-xl shadow-indigo-100 transition-all active:scale-[0.98]">
        Lanjutkan Booking
    </button>
    @endif

    {{-- STEP 3: FORM --}}
    @if ($step === 'form' && $selectedType)
    <button type="button" wire:click="back" class="text-xs font-bold text-slate-400 hover:text-indigo-600 mb-4 flex items-center gap-1 uppercase tracking-widest">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3"></path></svg> 
        Kembali
    </button>
    <h2 class="text-xl font-bold text-slate-900 mb-6 uppercase tracking-tight text-center">Booking Request</h2>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
            <input type="text" wire:model.defer="guest_name" placeholder="Nama Lengkap" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
            <div class="grid grid-cols-2 gap-4">
                <input type="email" wire:model.defer="guest_email" placeholder="Email" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                <input type="text" wire:model.defer="guest_phone" placeholder="No. Telepon" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs font-bold text-slate-400">
                <div>
                    <label class="ml-2 mb-1 block uppercase">Check In</label>
                    <input type="date" wire:model.defer="check_in" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="ml-2 mb-1 block uppercase">Check Out</label>
                    <input type="date" wire:model.defer="check_out" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
            <textarea wire:model.defer="special_request" class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 min-h-[100px] focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Ada permintaan khusus? (Opsional)"></textarea>
        </div>

        <button type="submit" 
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-100 transition-all flex items-center justify-center gap-2 group overflow-hidden relative">
            
            {{-- Teks Normal --}}
            <span wire:loading.remove wire:target="submit">Kirim Booking Sekarang</span>
            
            {{-- Teks Loading --}}
            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            </span>
        </button>
    </form>
    @endif
</div>