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
use getID3;

class ProfilNagariController extends Controller
{
    /**
     * Display the profil nagari form
     */
    public function index()
    {
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
    }

    /**
     * Store or update profil nagari
     */
    public function store(Request $request)
    {
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
            'video_profil' => 'nullable|mimetypes:video/mp4,video/avi,video/mov,video/wmv,video/flv,video/webm|max:51200', // 50MB max
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
            'banner.max' => 'Ukuran banner maksimal 5MB.',
            'video_profil.max' => 'Ukuran video maksimal 50MB.',
            'video_profil.mimetypes' => 'Format video harus MP4, AVI, MOV, WMV, FLV, atau WebM.',
            'video_url.url' => 'URL video tidak valid.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Ensure directories exist
            $this->ensureDirectoriesExist();

            $data = $request->except(['logo', 'banner', 'video_profil']);
            $profil = ProfilNagari::first();

            // Handle logo upload
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $logoResult = $this->handleFileUpload($request->file('logo'), 'logo', $profil);
                if ($logoResult['success']) {
                    $data['logo'] = $logoResult['filename'];
                } else {
                    return $this->handleUploadError($logoResult['message'], $request);
                }
            }

            // Handle banner upload
            if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
                $bannerResult = $this->handleFileUpload($request->file('banner'), 'banner', $profil);
                if ($bannerResult['success']) {
                    $data['banner'] = $bannerResult['filename'];
                } else {
                    return $this->handleUploadError($bannerResult['message'], $request);
                }
            }

            // Handle video upload
            if ($request->hasFile('video_profil') && $request->file('video_profil')->isValid()) {
                $videoResult = $this->handleVideoUpload($request->file('video_profil'), $profil);
                if ($videoResult['success']) {
                    $data['video_profil'] = $videoResult['filename'];
                    $data['video_durasi'] = $videoResult['duration'];
                    $data['video_size'] = $videoResult['size'];
                } else {
                    return $this->handleUploadError($videoResult['message'], $request);
                }
            }

            if ($profil) {
                $profil->update($data);
                $message = 'Profil Nagari berhasil diperbarui!';
                Log::info('Profil nagari updated', ['data' => $data]);
            } else {
                ProfilNagari::create($data);
                $message = 'Profil Nagari berhasil disimpan!';
                Log::info('Profil nagari created', ['data' => $data]);
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
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle video upload dengan metadata
     */
    private function handleVideoUpload($file, $existingProfile = null)
    {
        try {
            // Validasi ukuran file (50MB max)
            $maxSize = 50 * 1024 * 1024; // 50MB
            if ($file->getSize() > $maxSize) {
                return [
                    'success' => false,
                    'message' => 'Ukuran video terlalu besar. Maksimal 50MB'
                ];
            }

            // Validasi format video
            $allowedMimes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return [
                    'success' => false,
                    'message' => 'Format video tidak didukung. Gunakan MP4, AVI, MOV, WMV, FLV, atau WebM.'
                ];
            }

            // Hapus video lama jika ada
            if ($existingProfile && $existingProfile->getVideoFilename()) {
                $oldPath = public_path('uploads/videos/' . $existingProfile->getVideoFilename());
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                    Log::info('Old video deleted: ' . $oldPath);
                }
            }

            // Generate nama file unik
            $extension = $file->getClientOriginalExtension();
            $filename = 'video_profil_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('uploads/videos');

            // Pindahkan file
            $moved = $file->move($destinationPath, $filename);

            if (!$moved) {
                return [
                    'success' => false,
                    'message' => 'Gagal menyimpan video. Silakan coba lagi.'
                ];
            }

            $fullPath = $destinationPath . '/' . $filename;

            // Verifikasi file tersimpan
            if (!File::exists($fullPath)) {
                return [
                    'success' => false,
                    'message' => 'Video tidak dapat diverifikasi setelah upload.'
                ];
            }

            // Set permission yang benar
            chmod($fullPath, 0644);

            // Get video metadata (duration, size)
            $duration = null;
            $sizeInMB = round($file->getSize() / (1024 * 1024), 2);

            // Try to get video duration using getID3 (if available)
            if (class_exists('getID3')) {
                try {
                    $getID3 = new getID3;
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
     * Handle image upload (logo & banner)
     */
    private function handleFileUpload($file, $type, $existingProfile = null)
    {
        try {
            // Validasi file
            $maxSize = $type === 'logo' ? 2048 * 1024 : 5120 * 1024;
            if ($file->getSize() > $maxSize) {
                return [
                    'success' => false,
                    'message' => "Ukuran {$type} terlalu besar. Maksimal " . ($type === 'logo' ? '2MB' : '5MB')
                ];
            }

            // Cek ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return [
                    'success' => false,
                    'message' => "Format {$type} tidak didukung. Gunakan JPG, PNG, GIF, atau SVG."
                ];
            }

            // Hapus file lama jika ada
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

            // Generate nama file unik
            $filename = $type . '_' . time() . '_' . Str::random(10) . '.' . $extension;
            $destinationPath = public_path('uploads');
            $fullPath = $destinationPath . '/' . $filename;

            // Pindahkan file
            $moved = $file->move($destinationPath, $filename);

            if (!$moved) {
                return [
                    'success' => false,
                    'message' => "Gagal menyimpan {$type}. Silakan coba lagi."
                ];
            }

            // Verifikasi file tersimpan
            if (!File::exists($fullPath)) {
                return [
                    'success' => false,
                    'message' => "File {$type} tidak dapat diverifikasi setelah upload."
                ];
            }

            // Set permission yang benar
            chmod($fullPath, 0644);

            Log::info("{$type} uploaded successfully", [
                'filename' => $filename,
                'path' => $fullPath,
                'size' => $file->getSize(),
                'url' => asset('uploads/' . $filename)
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $fullPath,
                'url' => asset('uploads/' . $filename)
            ];

        } catch (\Exception $e) {
            Log::error("Error uploading {$type}: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return [
                'success' => false,
                'message' => "Terjadi kesalahan saat upload {$type}: " . $e->getMessage()
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
            'files_in_uploads' => File::exists(public_path('uploads')) ? File::files(public_path('uploads')) : 'Directory not exists',
            'files_in_videos' => File::exists(public_path('uploads/videos')) ? File::files(public_path('uploads/videos')) : 'Directory not exists'
        ];

        Log::info('Debug files info', $debug);
        return response()->json($debug);
    }

    /**
     * Get coordinates via AJAX
     */
    public function getCoordinates(Request $request)
    {
        try {
            $address = $request->input('address');

            return response()->json([
                'success' => true,
                'lat' => -0.9471,
                'lng' => 100.3543,
                'formatted_address' => $address ?? 'Padang, West Sumatra, Indonesia'
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting coordinates: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan koordinat'
            ], 500);
        }
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

            // Hapus file video
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
}
