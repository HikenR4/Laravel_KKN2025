<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::with('admin')
            ->latest('tanggal')
            ->paginate(10);

        return view('admin.berita', compact('berita'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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
            'featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['admin_id'] = Auth::guard('admin')->id();
        $data['slug'] = Str::slug($request->judul);
        $data['status'] = $request->status ?? 'published';
        $data['featured'] = $request->has('featured');

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/berita/gambar', $filename);
            $data['gambar'] = $filename;
        }

        Berita::create($data);

        return redirect()->route('admin.berita')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $berita = Berita::with('admin', 'komentarAktif')->findOrFail($id);
            
            // If AJAX request, return JSON
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $berita
                ]);
            }
            
            // Otherwise return view (if you have a detail page)
            return view('admin.berita-detail', compact('berita'));
            
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $berita
                ]);
            }
            
            // If you have an edit form page
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
            
            $request->validate([
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
                'featured' => 'boolean'
            ]);

            $data = $request->all();
            $data['slug'] = Str::slug($request->judul);
            $data['featured'] = $request->has('featured');

            // Handle file upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($berita->gambar && $berita->gambar !== 'default-news.jpg') {
                    $oldImagePath = 'public/berita/gambar/' . basename(parse_url($berita->gambar, PHP_URL_PATH));
                    Storage::delete($oldImagePath);
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/berita/gambar', $filename);
                $data['gambar'] = $filename;
            }

            $berita->update($data);

            return redirect()->route('admin.berita')
                ->with('success', 'Berita berhasil diperbarui.');
                
        } catch (\Exception $e) {
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
            
            // Delete image file if exists
            if ($berita->gambar && $berita->gambar !== 'default-news.jpg') {
                $imagePath = 'public/berita/gambar/' . basename(parse_url($berita->gambar, PHP_URL_PATH));
                Storage::delete($imagePath);
            }

            $berita->delete();

            // If AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.berita')
                ->with('success', 'Berita berhasil dihapus.');
                
        } catch (\Exception $e) {
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

            return response()->json([
                'success' => true,
                'featured' => $berita->featured,
                'message' => 'Status featured berhasil diubah.'
            ]);
            
        } catch (\Exception $e) {
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
                if ($item->gambar && $item->gambar !== 'default-news.jpg') {
                    $imagePath = 'public/berita/gambar/' . basename(parse_url($item->gambar, PHP_URL_PATH));
                    Storage::delete($imagePath);
                }
            }

            // Delete records
            Berita::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' berita berhasil dihapus.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}