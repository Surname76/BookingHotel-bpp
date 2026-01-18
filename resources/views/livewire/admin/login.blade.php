<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login – BookingHotel</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-neutral-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow p-8">

        <h1 class="text-2xl font-bold mb-6 text-center">
            Admin Login
        </h1>

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            <div>
                <label class="text-sm font-medium">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full border rounded-lg px-3 py-2"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:opacity-90"
            >
                Login Admin
            </button>
        </form>

        <p class="text-xs text-neutral-500 text-center mt-4">
            Halaman ini khusus untuk admin BookingHotel
        </p>
    </div>

</body>
</html>
