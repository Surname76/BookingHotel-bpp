<div class="min-h-screen bg-slate-50 py-10 px-6 sm:px-8 lg:px-12">
    <div class="max-w-7xl mx-auto">

        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Booking Requests</h1>
                <p class="text-slate-500 mt-1">Kelola permintaan booking yang masuk dari tamu.</p>
            </div>

            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama tamu..."
                    class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-900 focus:border-transparent outline-none w-full sm:w-64 transition-all shadow-sm">
                <svg class="absolute left-3 top-2.5 text-slate-400 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        {{-- FLASH MESSAGE --}}
        @if (session()->has('message'))
            <div
                class="mb-6 flex items-center gap-3 rounded-lg bg-emerald-50 px-4 py-3 text-emerald-700 border border-emerald-200 shadow-sm animate-fade-in-down">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium text-sm">{{ session('message') }}</span>
            </div>
        @endif

        {{-- MAIN CARD: TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                            <th class="pl-6 py-4 w-12 text-center">#</th>
                            <th class="px-6 py-4">Tamu</th>
                            <th class="px-6 py-4">Hotel & Kamar</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($requests as $index => $request)
                            <tr class="group hover:bg-blue-50/40 transition-colors duration-200 relative">
                                <td class="pl-6 py-4 text-center text-slate-400 text-xs font-mono">
                                    {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 relative">
                                    @if ($request->status === 'pending')
                                        <span class="absolute top-4 left-2 flex h-2 w-2">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                        </span>
                                    @endif

                                    <div class="flex flex-col">
                                        <span
                                            class="font-semibold text-slate-800 {{ $request->status === 'pending' ? 'pl-2' : '' }}">
                                            {{ $request->guest_name }}
                                        </span>
                                        <span
                                            class="text-xs text-slate-500 {{ $request->status === 'pending' ? 'pl-2' : '' }}">
                                            {{ $request->guest_email }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-medium text-slate-700">{{ $request->room->hotel->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $request->room->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($request->check_in)->format('d M') }}
                                    <span class="text-slate-400 mx-1">→</span>
                                    {{ \Carbon\Carbon::parse($request->check_out)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'sent' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'rejected' => 'bg-red-100 text-red-700 border-red-200',
                                            'confirmed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        ];
                                        $colorClass =
                                            $statusColors[$request->status] ??
                                            'bg-slate-100 text-slate-600 border-slate-200';
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium border {{ $colorClass }} capitalize shadow-sm">
                                            {{ $request->status }}
                                        </span>

                                        @php
                                            $pay = $request->latestPayment;
                                        @endphp

                                        @if ($pay)
                                            @php
                                                $payColors = [
                                                    'pending' => 'bg-slate-100 text-slate-700 border-slate-200',
                                                    'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'expired' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                                    'paid_conflict' => 'bg-red-50 text-red-700 border-red-200',
                                                ];

                                                $payClass =
                                                    $payColors[$pay->status] ??
                                                    'bg-slate-100 text-slate-700 border-slate-200';
                                            @endphp

                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium border {{ $payClass }} shadow-sm">
                                                bayar: {{ $pay->status }}
                                            </span>
                                        @endif

                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="select({{ $request->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-100 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p>Tidak ada data ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($requests->hasPages())
                <div class="bg-white border-t border-slate-200 px-6 py-4">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL (POPUP) DENGAN ANIMASI --}}
    @if ($selectedRequest)
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div wire:transition.opacity.duration.300ms
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto pointer-events-none">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                    <div wire:transition.scale.origin.center.duration.300ms
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg pointer-events-auto border border-slate-100">

                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-slate-800">Detail Booking</h3>
                            <button wire:click="closeModal"
                                class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-md hover:bg-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 mb-6">
                                <div>
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Nama Tamu
                                    </p>
                                    <p class="text-slate-800 font-medium">{{ $selectedRequest->guest_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Kontak</p>
                                    <p class="text-slate-800">{{ $selectedRequest->guest_phone ?? '-' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Email</p>
                                    <p class="text-slate-800">{{ $selectedRequest->guest_email }}</p>
                                </div>
                                <div class="col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-semibold text-blue-900 uppercase">Detail Kamar</span>
                                        <span class="text-xs font-bold text-slate-500">
                                            {{ \Carbon\Carbon::parse($selectedRequest->check_in)->diffInDays($selectedRequest->check_out) }}
                                            Malam
                                        </span>
                                    </div>
                                    <p class="text-lg font-bold text-slate-900">
                                        {{ $selectedRequest->room->hotel->name }}</p>
                                    <p class="text-sm text-slate-600">{{ $selectedRequest->room->name }}</p>
                                    <div class="mt-2 text-sm text-slate-500 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $selectedRequest->check_in }} - {{ $selectedRequest->check_out }}
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Admin</label>
                                    <textarea wire:model="adminNote" rows="3"
                                        class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-900 focus:ring focus:ring-blue-900/20 text-sm transition-all placeholder-slate-400"
                                        placeholder="Tambahkan catatan untuk internal atau balasan..."></textarea>
                                </div>

                                <div class="flex gap-3 pt-2">
                                    <button wire:click="updateStatus('rejected')" wire:loading.attr="disabled"
                                        class="flex-1 px-4 py-2.5 bg-white text-red-600 border border-red-200 hover:bg-red-50 hover:border-red-300 rounded-xl text-sm font-semibold transition-all shadow-sm flex justify-center items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Tolak
                                    </button>

                                    <button wire:click="updateStatus('sent')" wire:loading.attr="disabled"
                                        class="flex-1 px-4 py-2.5 bg-blue-900 text-white hover:bg-blue-800 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all flex justify-center items-center gap-2 group">
                                        <span>Kirim ke Hotel</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 group-hover:translate-x-1 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
