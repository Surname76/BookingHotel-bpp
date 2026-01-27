<div class="min-h-screen bg-slate-50 py-10 px-6 sm:px-8 lg:px-12">
    <div class="max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                    Admin Dashboard
                </h1>
                <p class="text-slate-500 mt-1">
                    Selamat datang kembali, <span class="font-semibold text-blue-900">{{ auth()->user()->name }}</span>
                </p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="group flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:-translate-x-1">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <a href="{{ route('admin.booking-requests') }}" 
               class="group relative bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-900/30 transition-all duration-300 ease-in-out hover:-translate-y-1 overflow-hidden">
                
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-300 blur-xl opacity-50"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center mb-4 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-900 transition-colors">
                            Booking Requests
                        </h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Kelola persetujuan dan data masuk permintaan booking hotel.
                        </p>
                    </div>

                    <div class="text-slate-300 group-hover:text-blue-900 group-hover:translate-x-1 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.manage-hotels') }}" 
               class="group relative bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-900/30 transition-all duration-300 ease-in-out hover:-translate-y-1 overflow-hidden">
                
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-300 blur-xl opacity-50"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center mb-4 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-900 transition-colors">
                            Manage Hotels
                        </h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Kelola Hotel dan Kamar Yang Ada.
                        </p>
                    </div>

                    <div class="text-slate-300 group-hover:text-blue-900 group-hover:translate-x-1 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('dashboard') }}" 
               class="group relative bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-900/30 transition-all duration-300 ease-in-out hover:-translate-y-1 overflow-hidden">
                
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 rounded-full bg-blue-50 group-hover:bg-blue-100 transition-colors duration-300 blur-xl opacity-50"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-900 flex items-center justify-center mb-4 group-hover:bg-blue-900 group-hover:text-white transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-900 transition-colors">
                            Home
                        </h3>
                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            To The Main Menu
                        </p>
                    </div>

                    <div class="text-slate-300 group-hover:text-blue-900 group-hover:translate-x-1 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </a>

            <div class="bg-slate-100 p-6 rounded-2xl border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                <span class="text-sm font-medium">Menu akan datang</span>
            </div>

        </div>
    </div>
</div>