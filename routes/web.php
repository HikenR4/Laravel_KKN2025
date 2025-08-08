<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\AgendaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes (jika ada)
Route::get('/', function () {
    return view('welcome');
});

// Test route
Route::get('/test', function () {
    return 'Test route works!';
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Routes untuk guest (belum login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login']);
    });

    // Routes untuk admin yang sudah login
    Route::middleware(['App\Http\Middleware\AdminMiddleware'])->group(function () {
        
        // Dashboard
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Berita routes
        Route::get('berita', [BeritaController::class, 'index'])->name('berita');
        Route::post('berita/store', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('berita/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::get('berita/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('berita/delete/{id}', [BeritaController::class, 'destroy'])->name('berita.delete');
        
        // Additional berita routes
        Route::post('berita/{id}/toggle-featured', [BeritaController::class, 'toggleFeatured'])->name('berita.toggle-featured');
        Route::get('berita/kategori/{kategori}', [BeritaController::class, 'getByKategori'])->name('berita.by-kategori');
        Route::delete('berita/bulk-delete', [BeritaController::class, 'bulkDelete'])->name('berita.bulk-delete');

        // Agenda routes
        Route::get('agenda', [AgendaController::class, 'index'])->name('agenda');
        Route::post('agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('agenda/show/{id}', [AgendaController::class, 'show'])->name('agenda.show');
        Route::get('agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
        Route::put('agenda/update/{id}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::delete('agenda/delete/{id}', [AgendaController::class, 'destroy'])->name('agenda.delete');
        
        // Additional agenda routes
        Route::get('agenda/kategori/{kategori}', [AgendaController::class, 'getByKategori'])->name('agenda.by-kategori');
        Route::get('agenda/upcoming', [AgendaController::class, 'getUpcoming'])->name('agenda.upcoming');
        Route::delete('agenda/bulk-delete', [AgendaController::class, 'bulkDelete'])->name('agenda.bulk-delete');

        // Pengumuman routes - KEMBALI KE BENTUK ASLI
        Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
        Route::post('pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('pengumuman/show/{id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
        Route::get('pengumuman/edit/{id}', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('pengumuman/update/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('pengumuman/delete/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.delete');
        Route::patch('pengumuman/{id}/status', [PengumumanController::class, 'updateStatus'])->name('pengumuman.update-status');
    
        // Additional pengumuman routes
        Route::get('pengumuman/kategori/{kategori}', [PengumumanController::class, 'getByKategori'])->name('pengumuman.by-kategori');
        Route::get('pengumuman/penting', [PengumumanController::class, 'getPenting'])->name('pengumuman.penting');
        Route::delete('pengumuman/bulk-delete', [PengumumanController::class, 'bulkDelete'])->name('pengumuman.bulk-delete');

        // Logout
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});