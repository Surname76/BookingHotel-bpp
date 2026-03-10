<div class="max-w-[1280px] mx-auto px-6 md:px-8 lg:px-10 py-6">
    <p class="text-slate-600 text-sm md:text-base mb-8">
        Lihat status request, pembayaran, dan booking yang sudah terkonfirmasi.
    </p>

    @if (session('message'))
        <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-slate-900">Booking Requests</h2>
                <p class="text-xs text-slate-500 mt-1">Request yang kamu buat + status pembayaran (Xendit).</p>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($bookingRequests as $request)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between gap-4">
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

                                @if ($request->special_request)
                                    <p class="text-xs text-slate-500 mt-2">
                                        Catatan: {{ $request->special_request }}
                                    </p>
                                @endif
                            </div>

                            @php
                                $latestPayment = $request->latestPayment;
                                $canEdit = ! $request->cancelled_at && ! in_array($request->status, ['confirmed', 'rejected'], true);
                            @endphp

                            <div class="shrink-0 text-right space-y-1">
                                @if ($latestPayment?->invoice_url && in_array($latestPayment->status, ['pending', 'invoice_failed', 'failed', 'expired'], true))
                                    <a
                                        href="{{ $latestPayment->invoice_url }}"
                                        class="text-xs font-semibold text-blue-600 hover:text-blue-700"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        Bayar
                                    </a>
                                @elseif (! $request->cancelled_at && $request->status !== 'confirmed')
                                    <button
                                        wire:click="pay({{ $request->id }})"
                                        class="text-xs font-semibold text-blue-600 hover:text-blue-700"
                                    >
                                        Coba bayar lagi
                                    </button>
                                @endif

                                @if ($canEdit)
                                    <button
                                        wire:click="startEdit({{ $request->id }})"
                                        class="block ml-auto text-xs font-semibold text-amber-600 hover:text-amber-700"
                                    >
                                        Edit
                                    </button>
                                @endif

                                @if (! $request->cancelled_at && $request->status === 'pending')
                                    <button
                                        wire:click="cancelRequest({{ $request->id }})"
                                        wire:confirm="Yakin mau batalkan request ini?"
                                        class="block ml-auto text-xs font-semibold text-rose-600 hover:text-rose-700"
                                    >
                                        Batalkan
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if ($editingRequestId === $request->id)
                            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                                <h3 class="text-sm font-semibold text-slate-900">Edit booking request</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Nama Tamu</label>
                                        <input type="text" wire:model.defer="editGuestName" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editGuestName') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Nomor HP</label>
                                        <input type="text" wire:model.defer="editGuestPhone" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editGuestPhone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Check-in</label>
                                        <input type="date" wire:model.defer="editCheckIn" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editCheckIn') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Jam Check-in</label>
                                        <input type="time" wire:model.defer="editCheckInTime" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editCheckInTime') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Check-out</label>
                                        <input type="date" wire:model.defer="editCheckOut" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editCheckOut') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs text-slate-500 mb-1">Jam Check-out</label>
                                        <input type="time" wire:model.defer="editCheckOutTime" class="w-full rounded-lg border-slate-300 text-sm">
                                        @error('editCheckOutTime') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Permintaan Khusus</label>
                                    <textarea wire:model.defer="editSpecialRequest" rows="3" class="w-full rounded-lg border-slate-300 text-sm"></textarea>
                                    @error('editSpecialRequest') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex items-center gap-3">
                                    <button wire:click="saveEdit" class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">Simpan Perubahan</button>
                                    <button wire:click="cancelEdit" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">Batal</button>
                                </div>
                            </div>
                        @endif

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Status: {{ $request->status }}</span>

                            @if ($request->cancelled_at)
                                <span class="px-2 py-1 rounded-full bg-rose-50 text-rose-700">Dibatalkan</span>
                            @endif

                            @if ($request->latestPayment)
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700">Bayar: {{ $request->latestPayment->status }}</span>
                            @endif

                            <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                Rp {{ number_format((float) $request->room->price_per_night * max(1, $request->check_in?->diffInDays($request->check_out)), 0, ',', '.') }}
                            </span>
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
