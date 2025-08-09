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
                'logo_exists' => $profil->hasLogoFile(),
                'banner_exists' => $profil->hasBannerFile()
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
    ]);

    if ($validator->fails()) {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $uploadsPath = public_path('uploads');
        if (!File::exists($uploadsPath)) {
            File::makeDirectory($uploadsPath, 0755, true);
            Log::info('Created uploads directory: ' . $uploadsPath);
        }

        $data = $request->except(['logo', 'banner']);
        $profil = ProfilNagari::first();

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '_' . Str::random(10) . '.' . $logo->getClientOriginalExtension();
            $logoPath = $logo->move($uploadsPath, $logoName);
            if ($logoPath) {
                $data['logo'] = $logoName;
                Log::info('Logo uploaded successfully', ['path' => $logoPath, 'filename' => $logoName]);
                if ($profil && $profil->logo) {
                    $oldLogoPath = public_path('uploads/' . $profil->logo);
                    if (File::exists($oldLogoPath)) {
                        File::delete($oldLogoPath);
                        Log::info('Old logo deleted: ' . $oldLogoPath);
                    }
                }
            } else {
                Log::error('Failed to move logo file', ['filename' => $logoName]);
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Gagal mengunggah logo'], 400);
                }
                return redirect()->back()->with('error', 'Gagal mengunggah logo')->withInput();
            }
        }

        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $banner = $request->file('banner');
            $bannerName = 'banner_' . time() . '_' . Str::random(10) . '.' . $banner->getClientOriginalExtension();
            $bannerPath = $banner->move($uploadsPath, $bannerName);
            if ($bannerPath) {
                $data['banner'] = $bannerName;
                Log::info('Banner uploaded successfully', ['path' => $bannerPath, 'filename' => $bannerName]);
                if ($profil && $profil->banner) {
                    $oldBannerPath = public_path('uploads/' . $profil->banner);
                    if (File::exists($oldBannerPath)) {
                        File::delete($oldBannerPath);
                        Log::info('Old banner deleted: ' . $oldBannerPath);
                    }
                }
            } else {
                Log::error('Failed to move banner file', ['filename' => $bannerName]);
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Gagal mengunggah banner'], 400);
                }
                return redirect()->back()->with('error', 'Gagal mengunggah banner')->withInput();
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
     * Handle file upload - LANGSUNG KE public/uploads
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

            // Pindahkan file langsung ke public/uploads
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
            'logo_url' => $profil->getLogoUrl(),
            'banner_url' => $profil->getBannerUrl(),
            'logo_exists' => $profil->hasLogoFile(),
            'banner_exists' => $profil->hasBannerFile(),
            'uploads_path' => public_path('uploads'),
            'uploads_exists' => File::exists(public_path('uploads')),
            'files_in_uploads' => File::exists(public_path('uploads')) ? File::files(public_path('uploads')) : 'Directory not exists'
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
}
