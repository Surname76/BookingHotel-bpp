<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Livewire\Rooms\Show;
use App\Livewire\Admin\BookingRequestList;

/*
|--------------------------------------------------------------------------
| HOME – LIST HOTEL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home', [
        'hotels' => Room::all(),
    ]);
});

/*
|--------------------------------------------------------------------------
| DETAIL HOTEL
|--------------------------------------------------------------------------
*/
Route::get('/rooms/{id}', Show::class)
    ->name('hotels.show');

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
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('layouts.app', ['slot' => view('livewire.admin.dashboard')]);
        })->name('admin.dashboard');

        Route::get('/booking-requests', BookingRequestList::class)
            ->name('admin.booking-requests');
    });
