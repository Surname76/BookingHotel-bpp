<div>

    {{-- STEP 1: PILIH KELAS --}}
    @if ($step === 'select')
        <h2 class="text-xl font-semibold mb-6">Pilih Kelas Kamar</h2>

        <div class="space-y-4">
            @foreach ($roomTypes as $type)
                <div class="border rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $type->name }}</h3>
                        <p class="text-sm text-neutral-500">{{ $type->description }}</p>
                        <p class="font-semibold mt-2">
                            Rp {{ number_format($type->price_per_night, 0, ',', '.') }} / malam
                        </p>
                    </div>

                    <button
                        wire:click="chooseType({{ $type->id }})"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                        Pilih
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    {{-- STEP 2: BENEFIT --}}
    @if ($step === 'benefit' && $selectedType)
        <button wire:click="back" class="text-sm text-neutral-500 mb-4">
            ← Kembali pilih kelas
        </button>

        <h2 class="text-xl font-semibold mb-4">
            Mengapa memilih {{ $selectedType->name }}?
        </h2>

        <ul class="space-y-3 mb-6">
            @foreach ($selectedType->benefits ?? [] as $benefit)
                <li class="flex gap-2">
                    <span class="text-green-600">✔</span>
                    <span>{{ $benefit }}</span>
                </li>
            @endforeach
        </ul>

        <button
            wire:click="proceedToForm"
            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold">
            Lanjutkan Booking
        </button>
    @endif

    {{-- STEP 3: FORM --}}
    @if ($step === 'form' && $selectedType)
        <button wire:click="back" class="text-sm text-neutral-500 mb-4">
            ← Kembali ke keuntungan
        </button>

        <h2 class="text-xl font-semibold mb-6">
            Booking Request – {{ $selectedType->name }}
        </h2>

        <form wire:submit.prevent="submit" class="space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <input type="date" wire:model="check_in" class="border rounded-lg px-3 py-2">
                <input type="date" wire:model="check_out" class="border rounded-lg px-3 py-2">
            </div>

            <input type="text" wire:model="guest_name"
                   placeholder="Nama Lengkap"
                   class="w-full border rounded-lg px-3 py-2">

            <input type="email" wire:model="guest_email"
                   placeholder="Email"
                   class="w-full border rounded-lg px-3 py-2">

            <input type="text" wire:model="guest_phone"
                   placeholder="Nomor Telepon"
                   class="w-full border rounded-lg px-3 py-2">

            <textarea
                wire:model="special_request"
                rows="3"
                placeholder="Permintaan khusus (opsional), contoh: kamar di lantai 2, dekat lift"
                class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>

            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold">
                Kirim Permintaan Booking
            </button>

            <p class="text-xs text-neutral-500 text-center">
                Permintaan ini akan diteruskan ke pihak hotel dan tidak bersifat mengikat.
            </p>
        </form>
    @endif

</div>
