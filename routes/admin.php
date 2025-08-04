<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Routes untuk guest (belum login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login']);
    });

    // Routes untuk admin yang sudah login
    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::post('logout', [AdminController::class, 'logout'])->name('logout');

        // Tambahkan routes admin lainnya di sini
        // Route::resource('berita', BeritaController::class);
        // Route::resource('agenda', AgendaController::class);
    });
});
