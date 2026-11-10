<?php

use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\DashboardOverviewController;
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
        Route::get('/dashboard', [DashboardOverviewController::class, 'displayDashboardMetrics'])
            ->name('dashboard.index');

        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');
    });

    // Modul Pelanggan (Administrator & Staff)
    Route::get('/customers', [CustomerManagementController::class, 'displayCustomerList'])
        ->name('customers.index');

    Route::get('/customers/create', [CustomerManagementController::class, 'showCustomerCreationForm'])
        ->name('customers.create');

    Route::post('/customers', [CustomerManagementController::class, 'storeNewCustomerRecord'])
        ->name('customers.store');

    Route::get('/customers/{customer}/edit', [CustomerManagementController::class, 'showCustomerEditingForm'])
        ->name('customers.edit');

    Route::put('/customers/{customer}', [CustomerManagementController::class, 'updateExistingCustomerRecord'])
        ->name('customers.update');

    // Hapus Pelanggan Khusus Administrator (Soft Delete)
    Route::delete('/customers/{customer}', [CustomerManagementController::class, 'deleteCustomerWithSoftDelete'])
        ->middleware(['role.administrator'])
        ->name('customers.destroy');

    Route::get('/invoices', function () {
        return view('invoices.index');
    })->name('invoices.index');
});
