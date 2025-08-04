<?php

use App\Http\Controllers\Admin\AdminController;
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
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});
