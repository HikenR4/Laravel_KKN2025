<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ProfilNagariController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PerangkatController;
use App\Http\Controllers\Admin\DataPendudukController;
use App\Http\Controllers\Admin\KomentarController;
use App\Http\Controllers\Admin\PublicController;
use App\Http\Controllers\Public\PengumumanpublicController;
use App\Http\Controllers\Public\LayananpublicController;
use App\Http\Controllers\Public\ProfilController;
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

// Landing page untuk masyarakat
Route::get('/landing', function () {
    return view('public.landing');
});

// Public routes for berita
Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PublicController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/berita/kategori/{kategori}', [PublicController::class, 'beritaByKategori'])->name('berita.kategori');

// Public routes for pengumuman
Route::get('/pengumuman', [PengumumanpublicController::class, 'index'])->name('pengumuman');
Route::get('/pengumuman/{slug}', [PengumumanpublicController::class, 'show'])->name('pengumuman.detail');
Route::get('/pengumuman/kategori/{kategori}', [PengumumanpublicController::class, 'byKategori'])->name('pengumuman.kategori');
Route::get('/pengumuman/target/{target}', [PengumumanpublicController::class, 'byTarget'])->name('pengumuman.target');
Route::get('/pengumuman-penting', [PengumumanpublicController::class, 'penting'])->name('pengumuman.penting');

// Additional public routes for better SEO and functionality
Route::get('/cari-berita', [PublicController::class, 'searchBerita'])->name('berita.search');
Route::get('/tag/{tag}', [PublicController::class, 'beritaByTag'])->name('berita.tag');

// Agenda routes - PUBLIC
Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda');
Route::get('/agenda/{slug}', [PublicController::class, 'agendaDetail'])->name('agenda.detail');
Route::get('/agenda/kategori/{kategori}', [PublicController::class, 'agendaByKategori'])->name('agenda.kategori');

// Public routes for layanan
Route::get('/layanan', [App\Http\Controllers\Public\LayananpublicController::class, 'index'])->name('layanan');
Route::get('/layanan/{slug}', [App\Http\Controllers\Public\LayananpublicController::class, 'show'])->name('layanan.detail');
Route::get('/layanan/kategori/{kategori}', [App\Http\Controllers\Public\LayananpublicController::class, 'kategori'])->name('layanan.kategori');
Route::get('/cari-layanan', [App\Http\Controllers\Public\LayananpublicController::class, 'search'])->name('layanan.search');

// Routes untuk halaman profil
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/perangkat-nagari', [ProfilController::class, 'perangkatNagari'])->name('perangkat-nagari');
    Route::get('/data-wilayah', [ProfilController::class, 'dataWilayah'])->name('data-wilayah');
});

// Route alternatif untuk kemudahan akses
Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
Route::get('/perangkat-nagari', [ProfilController::class, 'perangkatNagari'])->name('perangkat-nagari');
Route::get('/data-wilayah', [ProfilController::class, 'dataWilayah'])->name('data-wilayah');

// ====== API ROUTES UNTUK LANDING PAGE DATABASE INTEGRATION ======
Route::prefix('api')->name('api.')->group(function () {
    // Profil nagari data
    Route::get('/profil-nagari', [PublicController::class, 'getProfilNagari'])->name('profil-nagari');

    // Video profil - UPDATED WITH DATABASE SUPPORT
    Route::get('/profil-video', [PublicController::class, 'getProfilVideo'])->name('profil-video');
    Route::post('/profil-video/increment-views', [PublicController::class, 'incrementVideoViews'])->name('profil-video.increment-views');

    // Statistics untuk dashboard landing - UPDATED WITH DATABASE
    Route::get('/statistics', [PublicController::class, 'getPublicStatistics'])->name('statistics');

    // Latest content untuk sections di landing - UPDATED WITH DATABASE
    Route::get('/latest-content', [PublicController::class, 'getLatestContent'])->name('latest-content');

    // Additional API endpoints untuk frontend interactivity
    Route::get('/search-suggestions', [PublicController::class, 'getSearchSuggestions'])->name('search-suggestions');
    Route::get('/popular-content', [PublicController::class, 'getPopularContent'])->name('popular-content');
});

// Tentang routes - PUBLIC
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');


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
        Route::delete('profil/video/delete', [ProfilNagariController::class, 'deleteVideo'])->name('profil.video.delete');

        // Perangkat Nagari routes
        Route::get('perangkat', [PerangkatController::class, 'index'])->name('perangkat');
        Route::get('perangkat/detail/{id}', [PerangkatController::class, 'detail'])->name('perangkat.detail');
        Route::post('perangkat/store', [PerangkatController::class, 'store'])->name('perangkat.store');
        Route::get('perangkat/show/{id}', [PerangkatController::class, 'show'])->name('perangkat.show');
        Route::get('perangkat/edit/{id}', [PerangkatController::class, 'edit'])->name('perangkat.edit');
        Route::put('perangkat/update/{id}', [PerangkatController::class, 'update'])->name('perangkat.update');
        Route::delete('perangkat/delete/{id}', [PerangkatController::class, 'destroy'])->name('perangkat.delete');
        Route::patch('perangkat/{id}/status', [PerangkatController::class, 'updateStatus'])->name('perangkat.update-status');
        Route::post('perangkat/bulk-delete', [PerangkatController::class, 'bulkDelete'])->name('perangkat.bulk-delete');
        Route::post('perangkat/reorder', [PerangkatController::class, 'reorder'])->name('perangkat.reorder');

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

        // Komentar
        Route::get('komentar', [KomentarController::class, 'index'])->name('komentar');
        Route::get('komentar/show/{id}', [KomentarController::class, 'show'])->name('komentar.show');
        Route::patch('komentar/{id}/approve', [KomentarController::class, 'approve'])->name('komentar.approve');
        Route::patch('komentar/{id}/reject', [KomentarController::class, 'reject'])->name('komentar.reject');
        Route::delete('komentar/delete/{id}', [KomentarController::class, 'destroy'])->name('komentar.delete');
        Route::get('komentar/filter', [KomentarController::class, 'filter'])->name('komentar.filter');
        Route::delete('komentar/bulk-delete', [KomentarController::class, 'bulkDelete'])->name('komentar.bulk-delete');
        Route::post('komentar/bulk-action', [KomentarController::class, 'bulkAction'])->name('komentar.bulk-action');

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
