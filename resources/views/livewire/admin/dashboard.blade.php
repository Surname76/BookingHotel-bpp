<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <p class="text-neutral-600 mb-6">
        Selamat datang, {{ auth()->user()->name }}
    </p>

    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('admin.booking-requests') }}"
           class="bg-white border rounded-xl p-6 hover:shadow">
            <h3 class="font-semibold mb-2">Booking Requests</h3>
            <p class="text-sm text-neutral-500">
                Kelola permintaan booking hotel
            </p>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.logout') }}" class="mt-10">
        @csrf
        <button class="text-red-600 hover:underline">
            Logout
        </button>
    </form>
</div>
