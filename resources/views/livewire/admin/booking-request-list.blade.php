<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold mb-6">
        Booking Requests
    </h1>

    @if (session()->has('message'))
        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- LEFT: LIST --}}
        <div class="lg:col-span-2 bg-white border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-neutral-100 text-neutral-600">
                    <tr>
                        <th class="p-3 text-left">Hotel</th>
                        <th class="p-3">Kamar</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $req)
                        <tr class="border-t hover:bg-neutral-50">
                            <td class="p-3">
                                {{ $req->room->name }}
                            </td>
                            <td class="p-3 text-center">
                                {{ $req->roomType->name }}
                            </td>
                            <td class="p-3 text-center">
                                {{ $req->check_in }} <br>
                                <span class="text-xs text-neutral-500">s/d</span><br>
                                {{ $req->check_out }}
                            </td>
                            <td class="p-3 text-center">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($req->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($req->status === 'confirmed') bg-green-100 text-green-700
                                    @elseif($req->status === 'rejected') bg-red-100 text-red-700
                                    @else bg-neutral-200 text-neutral-600
                                    @endif
                                ">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <button
                                    wire:click="select({{ $req->id }})"
                                    class="text-indigo-600 text-sm font-medium hover:underline">
                                    Detail
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
                <h2 class="font-semibold mb-4">
                    Detail Booking
                </h2>

                <div class="space-y-2 text-sm mb-4">
                    <p><strong>Nama:</strong> {{ $selectedRequest->guest_name }}</p>
                    <p><strong>Email:</strong> {{ $selectedRequest->guest_email }}</p>
                    <p><strong>Telepon:</strong> {{ $selectedRequest->guest_phone ?? '-' }}</p>
                    <p><strong>Hotel:</strong> {{ $selectedRequest->room->name }}</p>
                    <p><strong>Kamar:</strong> {{ $selectedRequest->roomType->name }}</p>
                    <p><strong>Tanggal:</strong> {{ $selectedRequest->check_in }} → {{ $selectedRequest->check_out }}</p>
                </div>

                <textarea
                    wire:model="adminNote"
                    rows="3"
                    class="w-full border rounded-lg px-3 py-2 text-sm"
                    placeholder="Catatan untuk user / hotel">
                </textarea>

                <div class="flex gap-2 mt-4">
                    <button
                        wire:click="updateStatus('confirmed')"
                        class="flex-1 bg-green-600 text-white py-2 rounded-lg text-sm">
                        Konfirmasi
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
