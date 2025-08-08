<?php

// File: app/Http/Controllers/Admin/PengumumanController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Debug log
            Log::info('PengumumanController@index called');
            Log::info('Request URL: ' . $request->url());
            
            $query = Pengumuman::with('admin');

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan kategori
            if ($request->filled('kategori')) {
                $query->byKategori($request->kategori);
            }

            // Filter berdasarkan pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('konten', 'like', "%{$search}%");
                });
            }

            $pengumuman = $query->orderBy('created_at', 'desc')->paginate(15);
            
            $kategoriList = ['umum', 'penting', 'kegiatan', 'pelayanan', 'lainnya'];

            Log::info('About to return view: admin.pengumuman');
            return view('admin.pengumuman', compact('pengumuman', 'kategoriList'));
            
        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat memuat data pengumuman: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'konten' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_berakhir' => 'nullable|date_format:H:i|after:waktu_mulai',
                'kategori' => 'required|string|max:50',
                'target_audience' => 'required|string|max:50',
                'penting' => 'boolean',
                'status' => 'required|in:aktif,tidak_aktif',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Prepare data
            $data = [
                'judul' => $validated['judul'],
                'slug' => Str::slug($validated['judul']),
                'konten' => $validated['konten'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_berakhir' => $validated['tanggal_berakhir'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_berakhir' => $validated['waktu_berakhir'],
                'kategori' => $validated['kategori'],
                'target_audience' => $validated['target_audience'],
                'penting' => $request->has('penting'),
                'status' => $validated['status'],
                'views' => 0,
                'admin_id' => Auth::guard('admin')->id(),
            ];

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads/pengumuman
                $destinationPath = public_path('uploads/pengumuman');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = asset('uploads/pengumuman/' . $filename);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            // Create pengumuman
            $pengumuman = Pengumuman::create($data);

            if ($pengumuman) {
                Log::info('Pengumuman created successfully', ['id' => $pengumuman->id, 'judul' => $pengumuman->judul]);
                // 🔥 FIXED: Ganti route name yang benar
                return redirect()->route('admin.pengumuman')
                    ->with('success', 'Pengumuman berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan pengumuman.')
                    ->withInput();
            }

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid.');
        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@store: ' . $e->getMessage(), [
                'request_data' => $request->except(['gambar']),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pengumuman = Pengumuman::with('admin')->findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $pengumuman->id,
                        'judul' => $pengumuman->judul,
                        'konten' => $pengumuman->konten,
                        'tanggal_mulai' => $pengumuman->tanggal_mulai->format('Y-m-d'),
                        'tanggal_berakhir' => $pengumuman->tanggal_berakhir ? $pengumuman->tanggal_berakhir->format('Y-m-d') : null,
                        'waktu_mulai' => $pengumuman->waktu_mulai,
                        'waktu_berakhir' => $pengumuman->waktu_berakhir,
                        'kategori' => $pengumuman->kategori,
                        'target_audience' => $pengumuman->target_audience,
                        'penting' => $pengumuman->penting,
                        'status' => $pengumuman->status,
                        'views' => $pengumuman->views,
                        'gambar' => $pengumuman->gambar,
                        'slug' => $pengumuman->slug,
                        'admin' => $pengumuman->admin ? $pengumuman->admin->nama_lengkap : 'Unknown',
                        'created_at' => $pengumuman->created_at->format('d/m/Y H:i'),
                        'updated_at' => $pengumuman->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            // Return halaman detail pengumuman
            return view('admin.detail-pengumuman', compact('pengumuman'));

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@show: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('error', 'Pengumuman tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $pengumuman->id,
                        'judul' => $pengumuman->judul,
                        'konten' => $pengumuman->konten,
                        'tanggal_mulai' => $pengumuman->tanggal_mulai->format('Y-m-d'),
                        'tanggal_berakhir' => $pengumuman->tanggal_berakhir ? $pengumuman->tanggal_berakhir->format('Y-m-d') : null,
                        'waktu_mulai' => $pengumuman->waktu_mulai,
                        'waktu_berakhir' => $pengumuman->waktu_berakhir,
                        'kategori' => $pengumuman->kategori,
                        'target_audience' => $pengumuman->target_audience,
                        'penting' => $pengumuman->penting,
                        'status' => $pengumuman->status,
                        'gambar' => $pengumuman->gambar,
                    ]
                ]);
            }

            $kategoriList = ['umum', 'penting', 'kegiatan', 'pelayanan', 'lainnya'];
            $targetAudienceList = ['semua', 'warga', 'perangkat', 'tokoh_masyarakat'];
            
            return view('admin.pengumuman.edit', compact('pengumuman', 'kategoriList', 'targetAudienceList'));

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@edit: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('error', 'Pengumuman tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'konten' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_berakhir' => 'nullable|date_format:H:i',
                'kategori' => 'required|string|max:50',
                'target_audience' => 'required|string|max:50',
                'penting' => 'boolean',
                'status' => 'required|in:aktif,tidak_aktif',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'judul' => $validated['judul'],
                'slug' => Str::slug($validated['judul']),
                'konten' => $validated['konten'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_berakhir' => $validated['tanggal_berakhir'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_berakhir' => $validated['waktu_berakhir'],
                'kategori' => $validated['kategori'],
                'target_audience' => $validated['target_audience'],
                'penting' => $request->has('penting'),
                'status' => $validated['status'],
            ];

            // Handle file upload hanya jika ada file baru
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($pengumuman->gambar && strpos($pengumuman->gambar, 'default-') === false) {
                    $oldImagePath = str_replace(asset('uploads/pengumuman/'), '', $pengumuman->gambar);
                    $oldImageFullPath = public_path('uploads/pengumuman/' . $oldImagePath);
                    if (file_exists($oldImageFullPath)) {
                        unlink($oldImageFullPath);
                        Log::info('Old pengumuman image deleted: ' . $oldImageFullPath);
                    }
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads/pengumuman
                $destinationPath = public_path('uploads/pengumuman');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = asset('uploads/pengumuman/' . $filename);
                    Log::info('New pengumuman image uploaded: ' . $filename);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            $pengumuman->update($data);
            Log::info('Pengumuman updated successfully', ['id' => $pengumuman->id, 'judul' => $pengumuman->judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengumuman berhasil diperbarui.',
                    'data' => $pengumuman
                ]);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('success', 'Pengumuman berhasil diperbarui.');

        } catch (ValidationException $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data yang dimasukkan tidak valid.',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid.');
        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@update: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);

            // Delete image file if exists
            if ($pengumuman->gambar && strpos($pengumuman->gambar, 'default-') === false) {
                $imagePath = str_replace(asset('uploads/pengumuman/'), '', $pengumuman->gambar);
                $imageFullPath = public_path('uploads/pengumuman/' . $imagePath);
                if (file_exists($imageFullPath)) {
                    unlink($imageFullPath);
                    Log::info('Pengumuman image deleted: ' . $imageFullPath);
                }
            }

            $judul = $pengumuman->judul;
            $pengumuman->delete();
            Log::info('Pengumuman deleted successfully', ['id' => $id, 'judul' => $judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengumuman berhasil dihapus.'
                ]);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('success', 'Pengumuman berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@destroy: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            // 🔥 FIXED: Route name yang benar
            return redirect()->route('admin.pengumuman')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update status pengumuman
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);
            
            $pengumuman->update([
                'status' => $request->status
            ]);

            Log::info('Pengumuman status updated', ['id' => $id, 'status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status pengumuman berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@updateStatus: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pengumuman by kategori
     */
    public function getByKategori($kategori)
    {
        try {
            $pengumuman = Pengumuman::where('kategori', $kategori)
                ->latest('tanggal_mulai')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pengumuman
            ]);

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@getByKategori: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pengumuman penting
     */
    public function getPenting()
    {
        try {
            $pengumuman = Pengumuman::penting()
                ->where('status', 'aktif')
                ->latest('tanggal_mulai')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pengumuman
            ]);

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@getPenting: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete pengumuman
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pengumuman yang dipilih.'
                ], 400);
            }

            $pengumuman = Pengumuman::whereIn('id', $ids)->get();

            // Delete images
            foreach ($pengumuman as $item) {
                if ($item->gambar && strpos($item->gambar, 'default-') === false) {
                    $imagePath = str_replace(asset('uploads/pengumuman/'), '', $item->gambar);
                    $imageFullPath = public_path('uploads/pengumuman/' . $imagePath);
                    if (file_exists($imageFullPath)) {
                        unlink($imageFullPath);
                    }
                }
            }

            // Delete records
            Pengumuman::whereIn('id', $ids)->delete();
            Log::info('Bulk delete pengumuman completed', ['count' => count($ids), 'ids' => $ids]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' pengumuman berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in PengumumanController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}