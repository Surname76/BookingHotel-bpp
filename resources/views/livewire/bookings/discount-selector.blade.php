<div class="space-y-6">
    
    <!-- Available Discounts -->
    @if($availableDiscounts->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
                Promo Tersedia
            </h3>
            
            <div class="space-y-3">
                @foreach($availableDiscounts as $discount)
                    <label class="flex items-start gap-3 p-4 border border-slate-200 rounded-xl hover:border-blue-300 hover:bg-blue-50/50 transition cursor-pointer {{ in_array($discount->id, $selectedDiscounts) ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="checkbox" 
                            wire:click="toggleDiscount({{ $discount->id }})" 
                            {{ in_array($discount->id, $selectedDiscounts) ? 'checked' : '' }}
                            class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $discount->name }}</div>
                                    @if($discount->description)
                                        <p class="text-sm text-slate-600 mt-1">{{ $discount->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600">
                                        @if($discount->discount_type === 'percentage')
                                            {{ $discount->discount_value }}%
                                        @else
                                            Rp {{ number_format($discount->discount_value, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($discount->type === 'room_type') bg-purple-100 text-purple-700
                                    @elseif($discount->type === 'extended_stay') bg-blue-100 text-blue-700
                                    @elseif($discount->type === 'weekday') bg-green-100 text-green-700
                                    @elseif($discount->type === 'seasonal') bg-orange-100 text-orange-700
                                    @else bg-pink-100 text-pink-700
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $discount->type)) }}
                                </span>
                                
                                @if($discount->min_nights)
                                    <span class="px-2 py-1 text-xs bg-slate-100 text-slate-700 rounded-full">
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

    <!-- Voucher Code -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            Punya Kode Voucher?
        </h3>

        @if($appliedVoucher)
            <!-- Applied Voucher -->
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-green-900">{{ $appliedVoucher->name }}</div>
                            <code class="text-sm text-green-700 font-mono">{{ $appliedVoucher->code }}</code>
                        </div>
                    </div>
                    <button wire:click="removeVoucher" class="text-green-600 hover:text-green-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @else
            <!-- Voucher Input -->
            <div class="flex gap-2">
                <input type="text" wire:model="voucherCode" 
                    placeholder="Masukkan kode voucher"
                    class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase font-mono @error('voucherCode') border-red-500 @enderror">
                <button wire:click="applyVoucher" 
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition font-semibold">
                    Terapkan
                </button>
            </div>
            
            @if($voucherError)
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $voucherError }}
                </p>
            @endif

            @if(session()->has('voucher_success'))
                <p class="text-sm text-green-600 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('voucher_success') }}
                </p>
            @endif
        @endif
    </div>

    <!-- Price Summary -->
    <div class="bg-gradient-to-br from-blue-900 to-blue-800 rounded-2xl shadow-lg p-6 text-white">
        <h3 class="text-lg font-bold mb-4">Ringkasan Pembayaran</h3>
        
        <div class="space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-blue-100">Subtotal</span>
                <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            
            @if($totalDiscount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-blue-100">Total Diskon</span>
                    <span class="font-semibold text-green-300">- Rp {{ number_format($totalDiscount, 0, ',', '.') }}</span>
                </div>
            @endif
            
            <div class="pt-3 border-t border-blue-700">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold">Total Pembayaran</span>
                    <span class="text-2xl font-bold">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                </div>
            </div>
            
            @if($totalDiscount > 0)
                <div class="pt-2 text-center">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Hemat Rp {{ number_format($totalDiscount, 0, ',', '.') }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>