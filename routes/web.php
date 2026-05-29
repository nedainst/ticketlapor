<?php

use App\Http\Controllers\SocialAuthController;
use App\Livewire\Pages\Admin;
use App\Livewire\Pages\Auth;
use App\Livewire\Pages\EmergencyReport;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\TrackTicket;
use App\Livewire\Pages\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', Home::class)->name('home');
Route::get('/lacak', TrackTicket::class)->name('track');
Route::get('/darurat', EmergencyReport::class)->name('emergency');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Auth\Login::class)->name('login');
    Route::get('/register', Auth\Register::class)->name('register');
    Route::get('/lupa-password', Auth\ForgotPassword::class)->name('password.request');

    // Socialite Routes
    Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'callback']);
});

// Logout
Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // User Routes
    Route::prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', User\Dashboard::class)->name('dashboard');
        Route::get('/buat-laporan', User\CreateTicket::class)->name('tickets.create');
        Route::get('/laporan', User\MyTickets::class)->name('tickets');
        Route::get('/laporan/{ticket}', User\ViewTicket::class)->name('tickets.show');
        Route::get('/profil', User\Profile::class)->name('profile');
    });

    // Admin Routes
    Route::middleware('role:admin|super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', Admin\Dashboard::class)->name('dashboard');
        Route::get('/tiket', Admin\TicketList::class)->name('tickets');
        Route::get('/tiket/{ticket}', Admin\TicketDetail::class)->name('tickets.show');
        Route::get('/analitik', Admin\Analytics::class)->name('analytics');
        Route::get('/pengguna', Admin\UserManager::class)->name('users');
    });
});
