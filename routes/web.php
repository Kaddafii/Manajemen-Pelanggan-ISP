<?php

use App\Http\Controllers\UserAuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Manajemen Pelanggan ISP
|--------------------------------------------------------------------------
| Seluruh rute didefinisikan secara eksplisit sesuai ketentuan spesifikasi.
*/

// Rute Pengalihan Awal
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }

    return redirect()->route('login.form');
})->name('root.redirect');

// Grup Rute Tamu (Guest / Belum Terautentikasi)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserAuthenticationController::class, 'showLoginForm'])
        ->name('login.form');

    Route::post('/login', [UserAuthenticationController::class, 'authenticateUserCredentials'])
        ->name('login.authenticate');
});

// Grup Rute Terautentikasi (Auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserAuthenticationController::class, 'terminateUserSession'])
        ->name('logout.terminate');

    // Halaman Dashboard Utama (Placeholder sementara sebelum modul dashboard dibangun)
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');
});
