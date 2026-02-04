<div class="bg-slate-50 min-h-screen text-slate-900 font-sans pb-24">

    {{-- HERO SECTION --}}
    <div class="relative h-[45vh] lg:h-[55vh] overflow-hidden group mb-5">
        <div class="absolute inset-0 bg-slate-900">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&fit=crop" 
                 alt="Kantor" 
                 class="w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000 ease-out" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-50"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-center px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-300 text-xs font-bold tracking-wider uppercase mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                Pusat Bantuan
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4 drop-shadow-sm">
                Hubungi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-200">Tim Kami</span>
            </h1>
            <p class="text-slate-300 text-lg md:text-xl max-w-2xl font-light leading-relaxed">
                Kami siap membantu kebutuhan akomodasi dan menjawab pertanyaan bisnis Anda.
            </p>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 relative z-10 -mt-20">
        
        {{-- 
            GRID SYSTEM WITH SUBGRID 
            Parent: Mendefinisikan kolom.
            Gap-y-6: Menentukan jarak vertikal antar elemen 'track' di dalam kartu (Icon ke Judul, Judul ke Teks, dst).
        --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6 mb-10">
            
            {{-- WhatsApp Card --}}
            {{-- md:row-span-4 & md:grid-rows-subgrid: Kartu mengambil 4 baris grid parent agar isinya sejajar --}}
            <a href="https://wa.me/628123456789" target="_blank" class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white hover:border-green-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 grid grid-cols-1 md:grid-rows-subgrid md:row-span-4 gap-4">
                
                {{-- Track 1: Icon --}}
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-500 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.892a11.826 11.826 0 00-3.483-8.413z"/></svg>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-green-50 rounded-full">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-green-700 uppercase tracking-wide">Online</span>
                    </div>
                </div>

                {{-- Track 2: Title --}}
                <h3 class="text-xl font-bold text-slate-900">WhatsApp Chat</h3>

                {{-- Track 3: Body --}}
                <p class="text-slate-500 text-sm leading-relaxed">
                    Respon instan untuk reservasi, cek ketersediaan kamar, dan pertanyaan umum lainnya.
                </p>
                
                {{-- Track 4: Footer/Action --}}
                <div class="flex items-center justify-between border-t border-slate-100 pt-4 self-end">
                    <span class="text-slate-400 text-xs font-medium">Balasan &lt; 5 menit</span>
                    <span class="text-green-600 font-bold text-sm">Chat Sekarang →</span>
                </div>
            </a>

            {{-- Email Card --}}
            <a href="mailto:hello@perusahaan.com" class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white hover:border-blue-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 grid grid-cols-1 md:grid-rows-subgrid md:row-span-4 gap-4">
                
                {{-- Track 1: Icon --}}
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>

                {{-- Track 2: Title --}}
                <h3 class="text-xl font-bold text-slate-900">Email Official</h3>

                {{-- Track 3: Body --}}
                <p class="text-slate-500 text-sm leading-relaxed">
                    Saluran resmi untuk penawaran kerjasama B2B, legalitas perusahaan, dan kebutuhan korporat.
                </p>
                
                {{-- Track 4: Footer/Action --}}
                <div class="flex items-center justify-between border-t border-slate-100 pt-4 self-end">
                    <span class="text-slate-400 text-xs font-medium">Respon 1x24 Jam</span>
                    <span class="text-blue-600 font-bold text-sm">Kirim Email →</span>
                </div>
            </a>

            {{-- Location Card --}}
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white hover:border-slate-300 hover:shadow-2xl transition-all duration-300 grid grid-cols-1 md:grid-rows-subgrid md:row-span-4 gap-4">
                
                {{-- Track 1: Icon --}}
                <div class="flex justify-between items-start">
                    <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                    </div>
                </div>

                {{-- Track 2: Title --}}
                <h3 class="text-xl font-bold text-slate-900">Kantor Pusat</h3>

                {{-- Track 3: Body --}}
                <p class="text-slate-500 text-sm leading-relaxed">
                    Jl. Jenderal Sudirman No. 123, Balikpapan Tengah, Kalimantan Timur.
                </p>

                {{-- Track 4: Footer/Action --}}
                <div class="border-t border-slate-100 pt-4 self-end w-full">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 text-xs font-medium">Senin - Jumat</span>
                        <span class="text-slate-800 font-bold text-sm">09:00 - 17:00</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAP & DETAILS --}}
        <div class="bg-white rounded-[2.5rem] p-4 md:p-8 shadow-sm border border-slate-100">
            <div class="grid lg:grid-cols-12 gap-8">
                
                {{-- Map Embed --}}
                <div class="lg:col-span-8 h-[400px] lg:h-full min-h-[400px] rounded-[2rem] overflow-hidden relative shadow-inner bg-slate-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127641.168535035!2d116.814399!3d-1.242036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df1473950117d91%3A0x603f0b48a14f4949!2sBalikpapan%2C%20East%20Kalimantan!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                        class="w-full h-full border-0 grayscale hover:grayscale-0 transition-all duration-700" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-xl shadow-lg text-xs font-bold text-slate-800 border border-slate-100">
                        📍 Lokasi Kami
                    </div>
                </div>

                {{-- Side Info --}}
                <div class="lg:col-span-4 flex flex-col justify-center py-4 px-2">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Informasi Kunjungan</h2>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold">1</div>
                            <div>
                                <h4 class="font-bold text-slate-900">Parkir Tersedia</h4>
                                <p class="text-sm text-slate-500 mt-1 leading-relaxed">Area parkir luas gratis untuk tamu.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold">2</div>
                            <div>
                                <h4 class="font-bold text-slate-900">Janji Temu</h4>
                                <p class="text-sm text-slate-500 mt-1 leading-relaxed">Harap konfirmasi via WhatsApp sebelum datang.</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mt-4">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Jadwal Buka</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Senin - Jumat</span>
                                    <span class="font-bold text-slate-900">09:00 - 17:00</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-200 pt-2 mt-2">
                                    <span class="text-red-500 font-medium">Minggu</span>
                                    <span class="text-red-500 font-medium">Tutup</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>