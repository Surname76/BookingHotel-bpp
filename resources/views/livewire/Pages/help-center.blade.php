<div class="bg-slate-50 min-h-screen text-slate-900 font-sans pb-20">
    
    {{-- SEARCH AREA --}}
    <div class="bg-slate-900 pt-20 pb-32 px-6 relative overflow-hidden">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h1 class="text-3xl md:text-5xl font-black text-white mb-6">Ada yang bisa kami bantu?</h1>
            
            <div class="relative max-w-2xl mx-auto">
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       placeholder="Cari pertanyaan..." 
                       class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl py-4 px-6 pl-14 text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-2xl">
                
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg wire:loading.remove wire:target="search" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <svg wire:loading wire:target="search" class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- HASIL PENCARIAN FAQ --}}
    <div class="max-w-4xl mx-auto px-6 -mt-10 relative z-20">
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 p-8 md:p-12">
            <h2 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                <span class="w-8 h-1 bg-blue-600 rounded-full"></span>
                @if($search) Hasil pencarian untuk "{{ $search }}" @else Pertanyaan Populer @endif
            </h2>

            <div class="space-y-4">
                @forelse($faqs as $index => $faq)
                    <div x-data="{ open: false }" class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm transition-all hover:border-blue-200">
                        <button @click="open = !open" class="w-full p-5 text-left flex justify-between items-center group">
                            <span class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="p-5 pt-0 text-sm text-slate-500 leading-relaxed">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <img src="https://illustrations.popsy.co/slate/shrugging-person.svg" class="w-32 mx-auto mb-4 opacity-20" alt="Not found">
                        <p class="text-slate-400">Maaf, kami tidak menemukan jawaban untuk "{{ $search }}"</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>