{{-- HERO PROMOSI DENGAN COUNTDOWN --}}
<div class="relative py-16 md:py-24 px-6 overflow-hidden">
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
    
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center relative z-10">
        <div>
            {{-- COUNTDOWN TIMER (Alpine.js) --}}
            <div x-data="timer(new Date().setDate(new Date().getDate() + 3))" x-init="start()" class="flex gap-4 mb-8">
                <div class="text-center">
                    <div class="bg-slate-900 text-white w-12 h-12 rounded-xl flex items-center justify-center text-xl font-black shadow-lg" x-text="days">0</div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mt-1 tracking-widest">Hari</div>
                </div>
                <div class="text-center">
                    <div class="bg-slate-900 text-white w-12 h-12 rounded-xl flex items-center justify-center text-xl font-black shadow-lg" x-text="hours">0</div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mt-1 tracking-widest">Jam</div>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-xl flex items-center justify-center text-xl font-black shadow-lg shadow-blue-200" x-text="minutes">0</div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mt-1 tracking-widest">Menit</div>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-12 h-12 rounded-xl flex items-center justify-center text-xl font-black shadow-lg shadow-blue-200" x-text="seconds">0</div>
                    <div class="text-[10px] uppercase font-bold text-slate-400 mt-1 tracking-widest">Detik</div>
                </div>
            </div>

            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold tracking-widest uppercase rounded-full mb-6">
                Promo Terbatas Februari 2026
            </span>
            <h1 class="text-5xl md:text-7xl font-black leading-tight text-slate-900">
                Liburan Impian di <span class="text-blue-600">Balikpapan</span> Lebih Hemat.
            </h1>
            <p class="mt-6 text-slate-500 text-lg max-w-lg leading-relaxed">
                Dapatkan diskon hingga <span class="font-bold text-slate-900">35%</span> untuk reservasi hotel pilihan.
            </p>
            
            <div class="mt-10 flex flex-wrap gap-4">
                <button class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all transform active:scale-95">
                    Klaim Promo Sekarang
                </button>
            </div>
        </div>

        {{-- Gambar dan Floating Card (Tetap Sama) --}}
        <div class="relative">
            <div class="rounded-[3rem] overflow-hidden shadow-2xl border-[12px] border-white">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&fit=crop" alt="Promo Hotel" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
    {{-- SCRIPT UNTUK TIMER (Bisa diletakkan di bawah file blade atau di layout utama) --}}
    <script>
        function timer(expiry) {
            return {
                expiry: expiry,
                remaining: null,
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                format(num) {
                    return num < 10 ? '0' + num : num;
                },
                start() {
                    this.remaining = this.expiry - new Date().getTime();
                    setInterval(() => {
                        this.remaining -= 1000;
                        if (this.remaining < 0) return;
                        this.days = this.format(Math.floor(this.remaining / (1000 * 60 * 60 * 24)));
                        this.hours = this.format(Math.floor((this.remaining / (1000 * 60 * 60)) % 24));
                        this.minutes = this.format(Math.floor((this.remaining / 1000 / 60) % 60));
                        this.seconds = this.format(Math.floor((this.remaining / 1000) % 60));
                    }, 1000);
                }
            }
        }
    </script>
</div>
