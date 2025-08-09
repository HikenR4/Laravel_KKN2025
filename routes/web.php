<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ProfilNagariController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\DataPendudukController;
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

        // Profil Nagari routes
        Route::get('profil', [ProfilNagariController::class, 'index'])->name('profil.index');
        Route::post('profil/store', [ProfilNagariController::class, 'store'])->name('profil.store');
        Route::get('profil/coordinates', [ProfilNagariController::class, 'getCoordinates'])->name('profil.coordinates');
      
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

        // Layanan routes - BARU
        Route::get('layanan', [LayananController::class, 'index'])->name('layanan');
        Route::post('layanan/store', [LayananController::class, 'store'])->name('layanan.store');
        Route::get('layanan/show/{id}', [LayananController::class, 'show'])->name('layanan.show');
        Route::get('layanan/edit/{id}', [LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');
        Route::patch('layanan/{id}/status', [LayananController::class, 'updateStatus'])->name('layanan.update-status');
        
        // Additional layanan routes
        Route::delete('layanan/bulk-delete', [LayananController::class, 'bulkDelete'])->name('layanan.bulk-delete');
        Route::post('layanan/reorder', [LayananController::class, 'reorder'])->name('layanan.reorder');

        // Data Penduduk routes - BARU
        Route::get('datapenduduk', [DataPendudukController::class, 'index'])->name('datapenduduk');
        Route::post('datapenduduk/store', [DataPendudukController::class, 'store'])->name('datapenduduk.store');
        Route::get('datapenduduk/show/{id}', [DataPendudukController::class, 'show'])->name('datapenduduk.show');
        Route::get('datapenduduk/edit/{id}', [DataPendudukController::class, 'edit'])->name('datapenduduk.edit');
        Route::put('datapenduduk/update/{id}', [DataPendudukController::class, 'update'])->name('datapenduduk.update');
        Route::delete('datapenduduk/delete/{id}', [DataPendudukController::class, 'destroy'])->name('datapenduduk.delete');
        Route::patch('datapenduduk/{id}/status', [DataPendudukController::class, 'updateStatus'])->name('datapenduduk.update-status');
        
        // Additional data penduduk routes
        Route::get('datapenduduk/search', [DataPendudukController::class, 'search'])->name('datapenduduk.search');
        Route::get('datapenduduk/filter', [DataPendudukController::class, 'filter'])->name('datapenduduk.filter');
        Route::get('datapenduduk/by-rt/{rt}', [DataPendudukController::class, 'getByRT'])->name('datapenduduk.by-rt');
        Route::get('datapenduduk/by-rw/{rw}', [DataPendudukController::class, 'getByRW'])->name('datapenduduk.by-rw');
        Route::delete('datapenduduk/bulk-delete', [DataPendudukController::class, 'bulkDelete'])->name('datapenduduk.bulk-delete');
        Route::get('datapenduduk/export', [DataPendudukController::class, 'export'])->name('datapenduduk.export');
        Route::get('datapenduduk/statistics', [DataPendudukController::class, 'statistics'])->name('datapenduduk.statistics');

        // Logout
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});