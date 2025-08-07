<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $berita = Berita::with('admin')
                ->latest('tanggal')
                ->paginate(10);

            return view('admin.berita', compact('berita'));
        } catch (\Exception $e) {
            Log::error('Error in BeritaController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data berita.');
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
                'tanggal' => 'required|date',
                'kategori' => 'required|string|max:50',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alt_gambar' => 'nullable|string|max:255',
                'excerpt' => 'nullable|string|max:500',
                'tags' => 'nullable|string',
                'meta_description' => 'nullable|string|max:160',
                'status' => 'required|in:published,draft',
                'featured' => 'nullable|boolean'
            ]);

            // Prepare data
            $data = [
                'judul' => $validated['judul'],
                'konten' => $validated['konten'],
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'alt_gambar' => $validated['alt_gambar'] ?? null,
                'excerpt' => $validated['excerpt'] ?? null,
                'tags' => $validated['tags'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
                'status' => $validated['status'],
                'featured' => $request->has('featured') ? true : false,
                'admin_id' => Auth::guard('admin')->id(),
                'slug' => Str::slug($validated['judul']),
                'views' => 0
            ];

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads
                $destinationPath = public_path('uploads');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = $filename;
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            // Create berita
            $berita = Berita::create($data);

            if ($berita) {
                Log::info('Berita created successfully', ['id' => $berita->id, 'judul' => $berita->judul]);
                return redirect()->route('admin.berita')
                    ->with('success', 'Berita berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan berita.')
                    ->withInput();
            }

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid.');
        } catch (\Exception $e) {
            Log::error('Error in BeritaController@store: ' . $e->getMessage(), [
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
            $berita = Berita::with('admin')->findOrFail($id);

            // Increment view count untuk real page view (bukan AJAX)
            if (!request()->ajax()) {
                $berita->increment('views');
            }

            // Jika request AJAX (untuk modal - tidak digunakan lagi tapi tetap ada untuk fallback)
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $berita->id,
                        'judul' => $berita->judul,
                        'konten' => $berita->konten,
                        'excerpt' => $berita->excerpt,
                        'kategori' => $berita->kategori,
                        'tanggal' => $berita->tanggal->format('Y-m-d'),
                        'status' => $berita->status,
                        'featured' => $berita->featured,
                        'gambar' => $berita->gambar,
                        'alt_gambar' => $berita->alt_gambar,
                        'tags' => $berita->tags,
                        'meta_description' => $berita->meta_description,
                        'views' => $berita->views,
                        'slug' => $berita->slug,
                        'admin' => $berita->admin ? $berita->admin->nama_lengkap : 'Unknown',
                        'created_at' => $berita->created_at->format('d/m/Y H:i'),
                        'updated_at' => $berita->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            // Return halaman detail berita
            return view('admin.detail-berita', compact('berita'));

        } catch (\Exception $e) {
            Log::error('Error in BeritaController@show: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.berita')
                ->with('error', 'Berita tidak ditemukan.');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $berita->id,
                        'judul' => $berita->judul,
                        'konten' => $berita->konten,
                        'excerpt' => $berita->excerpt,
                        'kategori' => $berita->kategori,
                        'tanggal' => $berita->tanggal->format('Y-m-d'),
                        'status' => $berita->status,
                        'featured' => $berita->featured,
                        'gambar' => $berita->gambar,
                        'alt_gambar' => $berita->alt_gambar,
                        'tags' => $berita->tags,
                        'meta_description' => $berita->meta_description,
                    ]
                ]);
            }

            return view('admin.berita-edit', compact('berita'));

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.berita')
                ->with('error', 'Berita tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'konten' => 'required|string',
                'tanggal' => 'required|date',
                'kategori' => 'required|string|max:50',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alt_gambar' => 'nullable|string|max:255',
                'excerpt' => 'nullable|string|max:500',
                'tags' => 'nullable|string',
                'meta_description' => 'nullable|string|max:160',
                'status' => 'required|in:published,draft',
                'featured' => 'nullable|boolean'
            ]);

            $data = [
                'judul' => $validated['judul'],
                'konten' => $validated['konten'],
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'alt_gambar' => $validated['alt_gambar'] ?? null,
                'excerpt' => $validated['excerpt'] ?? null,
                'tags' => $validated['tags'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
                'status' => $validated['status'],
                'featured' => $request->has('featured') ? true : false,
                'slug' => Str::slug($validated['judul'])
            ];

            // Handle file upload hanya jika ada file baru
            if ($request->hasFile('gambar')) {
                // Delete old image if exists (tapi bukan default)
                if (isset($berita->attributes['gambar']) && $berita->attributes['gambar'] && $berita->attributes['gambar'] !== 'default-news.jpg') {
                    $oldImagePath = public_path('uploads/' . $berita->attributes['gambar']);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                        Log::info('Old image deleted: ' . $oldImagePath);
                    }
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads
                $destinationPath = public_path('uploads');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = $filename;
                    Log::info('New image uploaded: ' . $filename);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            $berita->update($data);
            Log::info('Berita updated successfully', ['id' => $berita->id, 'judul' => $berita->judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil diperbarui.',
                    'data' => $berita
                ]);
            }

            return redirect()->route('admin.berita')
                ->with('success', 'Berita berhasil diperbarui.');

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
            Log::error('Error in BeritaController@update: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.berita')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Delete image file if exists (but not default image)
            if (isset($berita->attributes['gambar']) && $berita->attributes['gambar'] && $berita->attributes['gambar'] !== 'default-news.jpg') {
                $imagePath = public_path('uploads/' . $berita->attributes['gambar']);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    Log::info('Image deleted: ' . $imagePath);
                }
            }

            $judul = $berita->judul;
            $berita->delete();
            Log::info('Berita deleted successfully', ['id' => $id, 'judul' => $judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.berita')
                ->with('success', 'Berita berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in BeritaController@destroy: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.berita')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $berita->update(['featured' => !$berita->featured]);

            Log::info('Berita featured status toggled', ['id' => $id, 'featured' => $berita->featured]);

            return response()->json([
                'success' => true,
                'featured' => $berita->featured,
                'message' => 'Status featured berhasil diubah.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in BeritaController@toggleFeatured: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get berita by kategori
     */
    public function getByKategori($kategori)
    {
        try {
            $berita = Berita::where('kategori', $kategori)
                ->where('status', 'published')
                ->latest('tanggal')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $berita
            ]);

        } catch (\Exception $e) {
            Log::error('Error in BeritaController@getByKategori: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete berita
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada berita yang dipilih.'
                ], 400);
            }

            $berita = Berita::whereIn('id', $ids)->get();

            // Delete images
            foreach ($berita as $item) {
                if (isset($item->attributes['gambar']) && $item->attributes['gambar'] && $item->attributes['gambar'] !== 'default-news.jpg') {
                    $imagePath = public_path('uploads/' . $item->attributes['gambar']);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            // Delete records
            Berita::whereIn('id', $ids)->delete();
            Log::info('Bulk delete completed', ['count' => count($ids), 'ids' => $ids]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' berita berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in BeritaController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
