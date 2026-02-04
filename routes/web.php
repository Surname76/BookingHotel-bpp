<?php

use App\Livewire\Admin\BookingRequestList;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\HotelCrud;
use App\Livewire\Pages\About;
use App\Livewire\Pages\HelpCenter;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Login as UserLogin;
use App\Livewire\Pages\PrivacyPolicy;
use App\Livewire\Pages\ContactPages;
use App\Livewire\Pages\Register as UserRegister;
use App\Livewire\Pages\Terms;
use App\Livewire\Rooms\Show;
use App\Livewire\Bookings\History as BookingHistory;
use App\Livewire\Payments\ReturnPage as PaymentReturnPage;
use App\Livewire\Actions\Logout;
use App\Http\Controllers\Webhooks\XenditWebhookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Avoid slow favicon requests going through view errors / 404.
Route::get('/favicon.ico', fn () => response('', 204));

/*
|--------------------------------------------------------------------------
| HOME - LIST HOTEL
|--------------------------------------------------------------------------
*/
Route::get('/', Home::class)->name('dashboard');
Route::get('/about', About::class)->name('about');
Route::get('/help-center', HelpCenter::class)->name('help-center');
Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
Route::get('/terms-and-conditions', Terms::class)->name('terms-and-conditions');
Route::get('/contact-us', ContactPages::class)->name('contact-us');

/*
|--------------------------------------------------------------------------
| DETAIL HOTEL (LIVEWIRE)
|--------------------------------------------------------------------------
*/
Route::get('/hotels/{hotel}', Show::class)->name('hotels.show');

Route::middleware('auth')->group(function (): void {
    Route::get('/my-bookings', BookingHistory::class)->name('bookings.history');
});

Route::get('/payments/return/{status}', PaymentReturnPage::class)->name('payments.return');

Route::post('/webhooks/xendit/invoices', [XenditWebhookController::class, 'invoices'])->name('webhooks.xendit.invoices');

/*
|--------------------------------------------------------------------------
| AUTH (USER)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function (): void {
    Route::get('/login', UserLogin::class)->name('login');
    Route::get('/register', UserRegister::class)->name('register');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', function () {
        return app(Logout::class)();
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN (OPSIONAL)
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
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        if (! Auth::user()->is_admin) {
            Auth::logout();

            return back()->withErrors(['email' => 'Anda bukan admin']);
        }

        request()->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Login gagal']);
})->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (FULL LIVEWIRE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function (): void {
        Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
        Route::get('/manage-hotels', HotelCrud::class)->name('admin.manage-hotels');
        Route::get('/booking-requests', BookingRequestList::class)->name('admin.booking-requests');
    });

Route::prefix('admin')->group(function (): void {
    Route::fallback(function () {
        return redirect('/')
            ->with('error', 'Alamat admin yang Anda tuju tidak terdaftar');
    });
});
