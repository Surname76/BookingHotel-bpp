<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Riwayat Pemesanan</h1>
            <p class="text-slate-500 mt-1">Lihat status request, pembayaran, dan booking yang sudah terkonfirmasi.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Kembali</a>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-2 gap-8">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-900">Booking Requests</h2>
                <p class="text-xs text-slate-500 mt-1">Request yang kamu buat + status pembayaran (Xendit).</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($bookingRequests as $request)
                    @php($pay = $request->latestPayment)
                    <div class="px-6 py-4 flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900 truncate">
                                {{ $request->room->hotel->name }} - {{ $request->room->name }}
                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Lokasi: {{ $request->room->hotel->district ?? '-' }}
                                @if ($request->room->hotel->map_link)
                                    • <a href="{{ $request->room->hotel->map_link }}" class="text-blue-600 hover:text-blue-700" target="_blank" rel="noopener">Maps</a>
                                @endif
                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Menginap:
                                {{ $request->check_in?->format('d M Y') }}{{ $request->check_in_time ? ' ('.$request->check_in_time.')' : '' }}
                                -
                                {{ $request->check_out?->format('d M Y') }}{{ $request->check_out_time ? ' ('.$request->check_out_time.')' : '' }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Dibuat: {{ $request->created_at?->format('d M Y H:i') }}
                            </p>

                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Status: {{ $request->status }}</span>
                                @if ($pay)
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Bayar: {{ $pay->status }}</span>
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Rp {{ number_format((float) $pay->amount, 0, ',', '.') }}</span>
                                @endif
                                @if ($request->cancelled_at)
                                    <span class="px-2 py-1 rounded-full bg-rose-50 text-rose-700">Dibatalkan</span>
                                @endif
                            </div>
                        </div>

                        <div class="shrink-0 flex flex-col items-end gap-2">
                            @if ($pay && $pay->status === 'pending' && $pay->invoice_url)
                                <a href="{{ $pay->invoice_url }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700" target="_blank" rel="noopener">
                                    Bayar
                                </a>
                            @elseif (! $pay || in_array($pay->status, ['invoice_failed', 'expired', 'failed'], true))
                                <button wire:click="pay({{ $request->id }})" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                    Coba bayar lagi
                                </button>
                            @endif

                            @if (! $request->cancelled_at && $request->status === 'pending')
                                <button
                                    wire:click="cancelRequest({{ $request->id }})"
                                    wire:confirm="Yakin mau batalkan request ini?"
                                    class="text-xs font-semibold text-rose-600 hover:text-rose-700"
                                >
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-500">
                        Belum ada booking request.
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-200">
                {{ $bookingRequests->links() }}
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-900">Bookings</h2>
                <p class="text-xs text-slate-500 mt-1">Akan muncul otomatis setelah pembayaran berhasil.</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($bookings as $booking)
                    <div class="px-6 py-4">
                        <p class="font-semibold text-slate-900 truncate">
                            {{ $booking->room->hotel->name }} - {{ $booking->room->name }}
                        </p>

                        <p class="text-xs text-slate-500 mt-1">
                            Lokasi: {{ $booking->room->hotel->district ?? '-' }}
                            @if ($booking->room->hotel->map_link)
                                • <a href="{{ $booking->room->hotel->map_link }}" class="text-blue-600 hover:text-blue-700" target="_blank" rel="noopener">Maps</a>
                            @endif
                        </p>

                        <p class="text-xs text-slate-500 mt-1">
                            Menginap:
                            {{ $booking->check_in?->format('d M Y') }}{{ $booking->check_in_time ? ' ('.$booking->check_in_time.')' : '' }}
                            -
                            {{ $booking->check_out?->format('d M Y') }}{{ $booking->check_out_time ? ' ('.$booking->check_out_time.')' : '' }}
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Dibuat: {{ $booking->created_at?->format('d M Y H:i') }}
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Status: {{ $booking->status }}</span>
                            <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">
                                Total: Rp {{ number_format((float) $booking->total_price, 0, ',', '.') }}
                            </span>
                            @if ($booking->payment)
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Bayar: {{ $booking->payment->status }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-500">
                        Belum ada booking.
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-200">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>

