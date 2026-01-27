<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login – BookingHotel</title>

    @vite(['resources/css/app.css'])

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-entry {
            animation: fadeUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-900/5 blur-3xl"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-slate-200/50 blur-3xl"></div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 animate-entry">
        
        <div class="flex flex-col items-center">
            <div class="h-14 w-14 bg-blue-900 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-900/30 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
                Admin Portal
            </h2>
            <p class="mt-2 text-center text-sm text-slate-500">
                Masuk untuk mengelola BookingHotel
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-2xl shadow-slate-200 rounded-2xl sm:px-10 border border-slate-100">
                
                {{-- ERROR MESSAGE (Styled) --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500 flex items-start gap-3">
                        <svg class="h-5 w-5 text-red-500 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm text-red-700 font-medium">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   autocomplete="email" 
                                   required 
                                   class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 sm:text-sm transition-all duration-200"
                                   placeholder="admin@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   autocomplete="current-password" 
                                   required 
                                   class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 sm:text-sm transition-all duration-200"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-all duration-300 transform hover:-translate-y-0.5">
                            Sign In
                        </button>
                    </div>
                </form>

            </div>
            
            <p class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} BookingHotel Management System. <br>Halaman akses terbatas.
            </p>
        </div>
    </div>

</body>
</html>