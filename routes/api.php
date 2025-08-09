<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VideoApiController;

// Video API routes
Route::prefix('video')->name('video.')->group(function () {
    Route::get('info', [VideoApiController::class, 'getVideoInfo'])->name('info');
    Route::get('stats', [VideoApiController::class, 'getVideoStats'])->name('stats');

    // Protected routes (require authentication)
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('upload', [VideoApiController::class, 'uploadVideo'])->name('upload');
        Route::post('external', [VideoApiController::class, 'setExternalVideo'])->name('external');
        Route::delete('delete', [VideoApiController::class, 'deleteVideo'])->name('delete');
        Route::post('optimize', [VideoApiController::class, 'optimizeVideo'])->name('optimize');
        Route::post('thumbnail', [VideoApiController::class, 'generateThumbnail'])->name('thumbnail');
    });
});
