<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- FLASH MESSAGE --}}
    @if (session()->has('message'))
        <div class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- LEFT: LIST --}}
        <div class="lg:col-span-2 bg-white border rounded-xl p-6">
            <h1 class="text-xl font-bold mb-6">Booking Requests</h1>

            <table class="w-full text-sm">
                <thead class="border-b text-neutral-500">
                    <tr>
                        <th class="text-left py-2">Nama</th>
                        <th>Hotel</th>
                        <th>Kamar</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($requests as $request)
                        <tr class="hover:bg-neutral-50">
                            <td class="py-3">{{ $request->guest_name }}</td>
                            <td>{{ $request->room->name }}</td>
                            <td>{{ $request->roomType->name }}</td>
                            <td class="capitalize">{{ $request->status }}</td>
                            <td class="text-right">
                                <button
                                    wire:click="select({{ $request->id }})"
                                    class="text-accent text-sm hover:underline">
                                    Lihat
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- RIGHT: DETAIL --}}
        <div class="bg-white border rounded-xl p-6">
            @if ($selectedRequest)
                <h2 class="font-semibold mb-4">Detail Booking</h2>

                <div class="space-y-2 text-sm mb-6">
                    <p><strong>Nama:</strong> {{ $selectedRequest->guest_name }}</p>
                    <p><strong>Email:</strong> {{ $selectedRequest->guest_email }}</p>
                    <p><strong>Telepon:</strong> {{ $selectedRequest->guest_phone ?? '-' }}</p>
                    <p><strong>Hotel:</strong> {{ $selectedRequest->room->name }}</p>
                    <p><strong>Kamar:</strong> {{ $selectedRequest->roomType->name }}</p>
                    <p>
                        <strong>Tanggal:</strong>
                        {{ $selectedRequest->check_in }} → {{ $selectedRequest->check_out }}
                    </p>
                    <p><strong>Status:</strong> {{ ucfirst($selectedRequest->status) }}</p>
                </div>

                {{-- ADMIN NOTE --}}
                <div class="mb-4">
                    <label class="text-sm font-medium">Catatan Admin</label>
                    <textarea
                        wire:model.defer="adminNote"
                        rows="3"
                        class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                </div>

                <div class="flex gap-2">
                    <button
                        wire:click="updateStatus('sent')"
                        class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm">
                        Kirim ke Hotel
                    </button>

                    <button
                        wire:click="updateStatus('rejected')"
                        class="flex-1 bg-red-600 text-white py-2 rounded-lg text-sm">
                        Tolak
                    </button>
                </div>
            @else
                <p class="text-sm text-neutral-500">
                    Pilih booking untuk melihat detail.
                </p>
            @endif
        </div>

    </div>
</div>
