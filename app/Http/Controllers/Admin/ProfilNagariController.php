<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilNagari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache; // TAMBAH INI

class ProfilNagariController extends Controller
{
    /**
     * Display the profil nagari form
     */
    public function index()
    {
        try {
            $profil = ProfilNagari::first();
            // Debug info
            if ($profil) {
                Log::info('Profil data loaded', [
                    'logo' => $profil->getLogoFilename(),
                    'banner' => $profil->getBannerFilename(),
                    'video' => $profil->getVideoFilename(),
                    'logo_exists' => $profil->hasLogoFile(),
                    'banner_exists' => $profil->hasBannerFile(),
                    'video_exists' => $profil->hasVideoFile()
                ]);
            }
            return view('admin.profil', compact('profil'));
        } catch (\Exception $e) {
            Log::error('Error loading profil page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman profil.');
        }
    }

    /**
     * Store or update profil nagari
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'nama_nagari' => 'required|string|max:100',
            'kode_nagari' => 'nullable|string|max:20',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'video_profil' => 'nullable|mimetypes:video/mp4,video/avi,video/mov,video/wmv,video/flv,video/webm|max:51200',
            'video_url' => 'nullable|url',
            'video_deskripsi' => 'nullable|string|max:500',
            'koordinat_lat' => 'nullable|numeric|between:-90,90',
            'koordinat_lng' => 'nullable|numeric|between:-180,180',
            'luas_wilayah' => 'nullable|string|max:50',
            'batas_utara' => 'nullable|string',
            'batas_selatan' => 'nullable|string',
            'batas_timur' => 'nullable|string',
            'batas_barat' => 'nullable|string',
            'jumlah_rt' => 'nullable|integer|min:0',
            'jumlah_rw' => 'nullable|integer|min:0',
        ], [
            'nama_nagari.required' => 'Nama nagari wajib diisi.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.mimes' => 'Logo harus berformat JPEG, PNG, JPG, GIF, atau SVG.',
            'banner.max' => 'Ukuran banner maksimal 5MB.',
            'banner.image' => 'Banner harus berupa file gambar.',
            'banner.mimes' => 'Banner harus berformat JPEG, PNG, JPG, GIF, atau SVG.',
            'video_profil.max' => 'Ukuran video maksimal 50MB.',
            'video_profil.mimetypes' => 'Format video harus MP4, AVI, MOV, WMV, FLV, atau WebM.',
            'video_url.url' => 'URL video tidak valid.',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Ensure directories exist
            $this->ensureDirectoriesExist();
            
            // Get existing profile
            $profil = ProfilNagari::first();
            
            // Prepare data (exclude file fields initially)
            $data = $request->except(['logo', 'banner', 'video_profil']);

            Log::info('Processing form data', [
                'has_logo' => $request->hasFile('logo'),
                'has_banner' => $request->hasFile('banner'),
                'has_video' => $request->hasFile('video_profil'),
                'logo_valid' => $request->hasFile('logo') ? $request->file('logo')->isValid() : false,
                'banner_valid' => $request->hasFile('banner') ? $request->file('banner')->isValid() : false,
                'video_valid' => $request->hasFile('video_profil') ? $request->file('video_profil')->isValid() : false,
            ]);

            // Handle logo upload
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                Log::info('Processing logo upload');
                $logoResult = $this->handleFileUpload($request->file('logo'), 'logo', $profil);
                if ($logoResult['success']) {
                    $data['logo'] = $logoResult['filename'];
                    Log::info('Logo upload successful', ['filename' => $logoResult['filename']]);
                } else {
                    Log::error('Logo upload failed', ['message' => $logoResult['message']]);
                    return $this->handleUploadError($logoResult['message'], $request);
                }
            } else {
                Log::info('No logo file to process or file invalid');
            }

            // Handle banner upload
            if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
                Log::info('Processing banner upload');
                $bannerResult = $this->handleFileUpload($request->file('banner'), 'banner', $profil);
                if ($bannerResult['success']) {
                    $data['banner'] = $bannerResult['filename'];
                    Log::info('Banner upload successful', ['filename' => $bannerResult['filename']]);
                } else {
                    Log::error('Banner upload failed', ['message' => $bannerResult['message']]);
                    return $this->handleUploadError($bannerResult['message'], $request);
                }
            } else {
                Log::info('No banner file to process or file invalid');
            }

            // Handle video upload
            if ($request->hasFile('video_profil') && $request->file('video_profil')->isValid()) {
                Log::info('Processing video upload');
                $videoResult = $this->handleVideoUpload($request->file('video_profil'), $profil);
                if ($videoResult['success']) {
                    $data['video_profil'] = $videoResult['filename'];
                    $data['video_durasi'] = $videoResult['duration'];
                    $data['video_size'] = $videoResult['size'];
                    Log::info('Video upload successful', ['filename' => $videoResult['filename']]);
                } else {
                    Log::error('Video upload failed', ['message' => $videoResult['message']]);
                    return $this->handleUploadError($videoResult['message'], $request);
                }
            }

            Log::info('Final data to save', $data);

            // Save or update profile
            if ($profil) {
                $profil->update($data);
                $message = 'Profil Nagari berhasil diperbarui!';
                Log::info('Profil nagari updated', ['id' => $profil->id, 'data' => $data]);
            } else {
                $profil = ProfilNagari::create($data);
                $message = 'Profil Nagari berhasil disimpan!';
                Log::info('Profil nagari created', ['id' => $profil->id, 'data' => $data]);
            }

            // TAMBAH: Clear semua cache yang berkaitan dengan profil
            $this->clearProfilCache();

            // Verify data was saved
            if ($profil) {
                $savedData = $profil->fresh();
                Log::info('Verification - saved data', [
                    'logo_saved' => $savedData->getLogoFilename(),
                    'banner_saved' => $savedData->getBannerFilename(),
                    'video_saved' => $savedData->getVideoFilename(),
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('admin.profil.index')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error saving profil nagari: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * TAMBAH: Method untuk clear cache profil
     */
    private function clearProfilCache()
    {
        try {
            // Clear cache keys yang mungkin digunakan untuk profil
            $cacheKeys = [
                'profil_nagari',
                'profil_nagari_data',
                'profil_video',
                'profil_statistics',
                'latest_content',
                'public_statistics',
                'popular_content'
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            // Clear cache dengan pattern jika menggunakan Redis
            if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                Cache::flush();
            }

            Log::info('Profil cache cleared successfully');
            
            // Optional: Clear view cache juga
            \Artisan::call('view:clear');
            
        } catch (\Exception $e) {
            Log::warning('Failed to clear profil cache: ' . $e->getMessage());
        }
    }

    // ... sisa method lainnya tetap sama seperti sebelumnya ...

    /**
     * Handle file upload (logo & banner) - IMPROVED VERSION
     */
    private function handleFileUpload($file, $type, $existingProfile = null)
    {
        try {
            Log::info("Starting {$type} upload", [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension()
            ]);

            // Validate file size
            $maxSize = $type === 'logo' ? 2048 * 1024 : 5120 * 1024;
            if ($file->getSize() > $maxSize) {
                return [
                    'success' => false,
                    'message' => "Ukuran {$type} terlalu besar. Maksimal " . ($type === 'logo' ? '2MB' : '5MB')
                ];
            }

            // Validate file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return [
                    'success' => false,
                    'message' => "Format {$type} tidak didukung. Gunakan JPG, PNG, GIF, atau SVG."
                ];
            }

            // Validate MIME type
            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return [
                    'success' => false,
                    'message' => "MIME type {$type} tidak valid: " . $file->getMimeType()
                ];
            }

            // Delete old file if exists
            if ($existingProfile) {
                $oldFilename = $type === 'logo' ? $existingProfile->getLogoFilename() : $existingProfile->getBannerFilename();
                if ($oldFilename) {
                    $oldPath = public_path('uploads/' . $oldFilename);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                        Log::info("Old {$type} deleted: " . $oldPath);
                    }
                }
            }

            // Generate unique filename
            $filename = $type . '_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('uploads');

            // Ensure destination exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
                Log::info('Created uploads directory: ' . $destinationPath);
            }

            // Move file using Laravel's move method
            $fullPath = $destinationPath . '/' . $filename;
            try {
                $moved = $file->move($destinationPath, $filename);
                Log::info("File moved successfully", [
                    'from' => $file->getPathname(),
                    'to' => $fullPath,
                    'moved_object' => get_class($moved)
                ]);
            } catch (\Exception $moveException) {
                Log::error("File move failed: " . $moveException->getMessage());
                return [
                    'success' => false,
                    'message' => "Gagal memindahkan file {$type}: " . $moveException->getMessage()
                ];
            }

            // Verify file exists after move
            if (!File::exists($fullPath)) {
                Log::error("File verification failed - file does not exist at: " . $fullPath);
                return [
                    'success' => false,
                    'message' => "File {$type} tidak dapat diverifikasi setelah upload."
                ];
            }

            // Set proper permissions
            try {
                chmod($fullPath, 0644);
                Log::info("File permissions set successfully");
            } catch (\Exception $chmodException) {
                Log::warning("Could not set file permissions: " . $chmodException->getMessage());
            }

            // Final verification
            $fileSize = filesize($fullPath);
            $isReadable = is_readable($fullPath);

            Log::info("{$type} upload completed successfully", [
                'filename' => $filename,
                'full_path' => $fullPath,
                'file_size' => $fileSize,
                'is_readable' => $isReadable,
                'url' => asset('uploads/' . $filename)
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $fullPath,
                'url' => asset('uploads/' . $filename),
                'size' => $fileSize
            ];

        } catch (\Exception $e) {
            Log::error("Error uploading {$type}: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'message' => "Terjadi kesalahan saat upload {$type}: " . $e->getMessage()
            ];
        }
    }

    /**
     * Handle video upload dengan metadata
     */
    private function handleVideoUpload($file, $existingProfile = null)
    {
        try {
            Log::info("Starting video upload", [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            // Validate file size (50MB max)
            $maxSize = 50 * 1024 * 1024;
            if ($file->getSize() > $maxSize) {
                return [
                    'success' => false,
                    'message' => 'Ukuran video terlalu besar. Maksimal 50MB'
                ];
            }

            // Validate MIME type
            $allowedMimes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return [
                    'success' => false,
                    'message' => 'Format video tidak didukung. Gunakan MP4, AVI, MOV, WMV, FLV, atau WebM.'
                ];
            }

            // Delete old video if exists
            if ($existingProfile && $existingProfile->getVideoFilename()) {
                $oldPath = public_path('uploads/videos/' . $existingProfile->getVideoFilename());
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                    Log::info('Old video deleted: ' . $oldPath);
                }
            }

            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $filename = 'video_profil_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('uploads/videos');

            // Ensure destination exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
                Log::info('Created videos directory: ' . $destinationPath);
            }

            // Move file
            $moved = $file->move($destinationPath, $filename);
            $fullPath = $destinationPath . '/' . $filename;

            if (!$moved || !File::exists($fullPath)) {
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan video. Silakan coba lagi.'
                ];
            }

            // Set permissions
            chmod($fullPath, 0644);

            // Get video metadata
            $sizeInMB = round($file->getSize() / (1024 * 1024), 2);
            $duration = null;

            // Try to get video duration using getID3 (if available)
            if (class_exists('getID3')) {
                try {
                    $getID3 = new \getID3;
                    $fileInfo = $getID3->analyze($fullPath);
                    if (isset($fileInfo['playtime_seconds'])) {
                        $duration = (int) $fileInfo['playtime_seconds'];
                    }
                } catch (\Exception $e) {
                    Log::warning('Could not get video duration: ' . $e->getMessage());
                }
            }

            Log::info('Video uploaded successfully', [
                'filename' => $filename,
                'path' => $fullPath,
                'size' => $sizeInMB . 'MB',
                'duration' => $duration . ' seconds',
                'url' => asset('uploads/videos/' . $filename)
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $fullPath,
                'url' => asset('uploads/videos/' . $filename),
                'duration' => $duration,
                'size' => $sizeInMB
            ];

        } catch (\Exception $e) {
            Log::error('Error uploading video: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat upload video: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Ensure required directories exist
     */
    private function ensureDirectoriesExist()
    {
        $directories = [
            public_path('uploads'),
            public_path('uploads/videos')
        ];

        foreach ($directories as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
                Log::info('Created directory: ' . $dir);
            }
        }
    }

    /**
     * Handle upload error response
     */
    private function handleUploadError($message, $request)
    {
        Log::error('Upload error: ' . $message);
        
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => $message], 400);
        }
        
        return redirect()->back()->with('error', $message)->withInput();
    }

    /**
     * Debug method untuk cek file
     */
    public function debugFiles()
    {
        $profil = ProfilNagari::first();
        
        if (!$profil) {
            return response()->json(['message' => 'No profile found']);
        }

        $debug = [
            'profile_id' => $profil->id,
            'logo_filename' => $profil->getLogoFilename(),
            'banner_filename' => $profil->getBannerFilename(),
            'video_filename' => $profil->getVideoFilename(),
            'logo_url' => $profil->getLogoUrl(),
            'banner_url' => $profil->getBannerUrl(),
            'video_url' => $profil->getVideoUrl(),
            'logo_exists' => $profil->hasLogoFile(),
            'banner_exists' => $profil->hasBannerFile(),
            'video_exists' => $profil->hasVideoFile(),
            'uploads_path' => public_path('uploads'),
            'videos_path' => public_path('uploads/videos'),
            'uploads_exists' => File::exists(public_path('uploads')),
            'videos_exists' => File::exists(public_path('uploads/videos')),
            'uploads_writable' => is_writable(public_path('uploads')),
            'videos_writable' => is_writable(public_path('uploads/videos')),
        ];

        if (File::exists(public_path('uploads'))) {
            $debug['files_in_uploads'] = File::files(public_path('uploads'));
        }
        
        if (File::exists(public_path('uploads/videos'))) {
            $debug['files_in_videos'] = File::files(public_path('uploads/videos'));
        }

        Log::info('Debug files info', $debug);
        return response()->json($debug);
    }

    /**
     * Delete video AJAX endpoint
     */
    public function deleteVideo(Request $request)
    {
        try {
            $profil = ProfilNagari::first();
            
            if (!$profil || !$profil->getVideoFilename()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video tidak ditemukan'
                ], 404);
            }

            // Delete video file
            $videoPath = public_path('uploads/videos/' . $profil->getVideoFilename());
            if (File::exists($videoPath)) {
                File::delete($videoPath);
            }

            // Update database
            $profil->update([
                'video_profil' => null,
                'video_durasi' => null,
                'video_size' => null
            ]);

            // TAMBAH: Clear cache setelah delete video
            $this->clearProfilCache();

            return response()->json([
                'success' => true,
                'message' => 'Video berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting video: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus video'
            ], 500);
        }
    }

    public function deleteLogo(Request $request)
    {
        try {
            $profil = ProfilNagari::first();
            
            if (!$profil || !$profil->getLogoFilename()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logo tidak ditemukan'
                ], 404);
            }

            // Delete logo file
            $logoPath = public_path('uploads/' . $profil->getLogoFilename());
            if (File::exists($logoPath)) {
                File::delete($logoPath);
            }

            // Update database - set logo to null
            $profil->update([
                'logo' => null
            ]);

            // Clear cache setelah delete logo
            $this->clearProfilCache();

            return response()->json([
                'success' => true,
                'message' => 'Logo berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting logo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus logo'
            ], 500);
        }
    }

    /**
     * Delete banner AJAX endpoint
     */
    public function deleteBanner(Request $request)
    {
        try {
            $profil = ProfilNagari::first();
            
            if (!$profil || !$profil->getBannerFilename()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Banner tidak ditemukan'
                ], 404);
            }

            // Delete banner file
            $bannerPath = public_path('uploads/' . $profil->getBannerFilename());
            if (File::exists($bannerPath)) {
                File::delete($bannerPath);
            }

            // Update database - set banner to null
            $profil->update([
                'banner' => null
            ]);

            // Clear cache setelah delete banner
            $this->clearProfilCache();

            return response()->json([
                'success' => true,
                'message' => 'Banner berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting banner: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus banner'
            ], 500);
        }
    }
}