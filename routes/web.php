<?php

use App\Http\Controllers\UserAuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Manajemen Pelanggan ISP
|--------------------------------------------------------------------------
| Seluruh rute didefinisikan secara eksplisit sesuai ketentuan spesifikasi.
*/

// Rute Pengalihan Awal Berdasarkan Status Login & Role
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdministratorRole()
            ? redirect()->route('dashboard.index')
            : redirect()->route('customers.index');
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

    // Grup Rute Khusus Administrator
    Route::middleware(['role.administrator'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard.index');

        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');
    });

    // Grup Rute Bersama (Administrator & Staff)
    Route::get('/customers', function () {
        return view('customers.index');
    })->name('customers.index');

    Route::get('/invoices', function () {
        return view('invoices.index');
    })->name('invoices.index');
});
