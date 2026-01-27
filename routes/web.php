<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Livewire\Rooms\Show;
use App\Livewire\Admin\BookingRequestList;
use App\Livewire\Pages\About;
use App\Livewire\Pages\HelpCenter;
use App\Livewire\Pages\PrivacyPolicy;
use App\Livewire\Pages\terms;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\HotelCrud;
use App\Livewire\Pages\Home;

/*
|--------------------------------------------------------------------------
| HOME – LIST HOTEL
|--------------------------------------------------------------------------
*/
Route::get('/', Home::class)->name('dashboard');
Route::get('/about', About::class)->name('about');
route::get('/help-center', HelpCenter::class)->name('help-center');
route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
route::get('/terms-and-conditions', Terms::class)->name('terms-and-conditions');

/*
|--------------------------------------------------------------------------
| DETAIL HOTEL (LIVEWIRE)
|--------------------------------------------------------------------------
*/
Route::get('/hotels/{hotel}', Show::class)->name('hotels.show');
/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return view('livewire.admin.login');
})->name('admin.login');

Route::post('/admin/login', function () {
    $credentials = request()->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        if (!Auth::user()->is_admin) {
            Auth::logout();
            return back()->withErrors(['email' => 'Anda bukan admin']);
        }

        request()->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Login gagal']);
})->name('admin.login.submit');

Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (FULL LIVEWIRE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)
            ->name('admin.dashboard');

        Route::get('/manage-hotels', HotelCrud::class)
            ->name('admin.manage-hotels');

        Route::get('/booking-requests', BookingRequestList::class)
            ->name('admin.booking-requests');
    });

Route::prefix('admin')->group(function (): void {
    Route::fallback(function () {
        return redirect('/')
            ->with('error', 'Alamat admin yang Anda tuju tidak terdaftar');
    });
});
