<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ProfilNagariController;
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

        // Logout
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});
