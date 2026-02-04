<div class="max-w-3xl mx-auto px-6 py-16">
    <div class="bg-white border border-slate-200 rounded-2xl p-8">
        @if ($status === 'success')
            <h1 class="text-2xl font-black text-slate-900">Pembayaran diterima</h1>
            <p class="mt-2 text-slate-600">Jika booking belum muncul, tunggu beberapa detik lalu cek riwayat pemesanan.</p>
        @else
            <h1 class="text-2xl font-black text-slate-900">Pembayaran belum berhasil</h1>
            <p class="mt-2 text-slate-600">Kamu bisa coba bayar lagi dari halaman riwayat pemesanan.</p>
        @endif

        <div class="mt-6 flex items-center gap-3">
            <a href="{{ route('bookings.history') }}" class="px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Lihat Riwayat
            </a>
            <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-800 font-semibold hover:bg-slate-200 transition">
                Kembali ke Home
            </a>
        </div>
    </div>
</div>

