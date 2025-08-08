<?php

// File: app/Http/Controllers/Admin/LayananController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Debug log
            Log::info('LayananController@index called');
            Log::info('Request URL: ' . $request->url());
            
            $query = Layanan::query();

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama_layanan', 'like', "%{$search}%")
                      ->orWhere('kode_layanan', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            $layanan = $query->orderBy('urutan', 'asc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(15);

            Log::info('About to return view: admin.layanan');
            return view('admin.layanan', compact('layanan'));
            
        } catch (\Exception $e) {
            Log::error('Error in LayananController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat memuat data layanan: ' . $e->getMessage());
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
                'kode_layanan' => 'nullable|string|max:20|unique:layanan,kode_layanan',
                'nama_layanan' => 'required|string|max:200',
                'deskripsi' => 'required|string',
                'persyaratan' => 'required|string',
                'prosedur' => 'required|string',
                'biaya' => 'nullable|string|max:50',
                'waktu_penyelesaian' => 'nullable|string|max:50',
                'dasar_hukum' => 'nullable|string',
                'output_layanan' => 'nullable|string|max:200',
                'penanggung_jawab' => 'required|string|max:100',
                'kontak' => 'nullable|string|max:50',
                'formulir_url' => 'nullable|url',
                'status' => 'required|in:aktif,tidak_aktif',
                'urutan' => 'nullable|integer|min:0',
            ]);

            // Generate kode layanan jika kosong
            if (empty($validated['kode_layanan'])) {
                $validated['kode_layanan'] = 'LAY-' . str_pad(Layanan::count() + 1, 4, '0', STR_PAD_LEFT);
            }

            // Prepare data
            $data = [
                'kode_layanan' => $validated['kode_layanan'],
                'nama_layanan' => $validated['nama_layanan'],
                'slug' => Str::slug($validated['nama_layanan']),
                'deskripsi' => $validated['deskripsi'],
                'persyaratan' => $validated['persyaratan'],
                'prosedur' => $validated['prosedur'],
                'biaya' => $validated['biaya'] ?: 'Gratis',
                'waktu_penyelesaian' => $validated['waktu_penyelesaian'] ?: '1-3 Hari Kerja',
                'dasar_hukum' => $validated['dasar_hukum'],
                'output_layanan' => $validated['output_layanan'],
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'kontak' => $validated['kontak'],
                'formulir_url' => $validated['formulir_url'],
                'status' => $validated['status'],
                'urutan' => $validated['urutan'] ?: 0,
            ];

            // Create layanan
            $layanan = Layanan::create($data);

            if ($layanan) {
                Log::info('Layanan created successfully', ['id' => $layanan->id, 'nama_layanan' => $layanan->nama_layanan]);
                return redirect()->route('admin.layanan')
                    ->with('success', 'Layanan berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan layanan.')
                    ->withInput();
            }

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid.');
        } catch (\Exception $e) {
            Log::error('Error in LayananController@store: ' . $e->getMessage(), [
                'request_data' => $request->all(),
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
            $layanan = Layanan::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $layanan->id,
                        'kode_layanan' => $layanan->kode_layanan,
                        'nama_layanan' => $layanan->nama_layanan,
                        'slug' => $layanan->slug,
                        'deskripsi' => $layanan->deskripsi,
                        'persyaratan' => $layanan->persyaratan,
                        'prosedur' => $layanan->prosedur,
                        'biaya' => $layanan->biaya,
                        'waktu_penyelesaian' => $layanan->waktu_penyelesaian,
                        'dasar_hukum' => $layanan->dasar_hukum,
                        'output_layanan' => $layanan->output_layanan,
                        'penanggung_jawab' => $layanan->penanggung_jawab,
                        'kontak' => $layanan->kontak,
                        'formulir_url' => $layanan->formulir_url,
                        'status' => $layanan->status,
                        'urutan' => $layanan->urutan,
                        'created_at' => $layanan->created_at->format('d/m/Y H:i'),
                        'updated_at' => $layanan->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            // Return halaman detail layanan
            return view('admin.detail-layanan', compact('layanan'));

        } catch (\Exception $e) {
            Log::error('Error in LayananController@show: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.layanan')
                ->with('error', 'Layanan tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $layanan->id,
                        'kode_layanan' => $layanan->kode_layanan,
                        'nama_layanan' => $layanan->nama_layanan,
                        'deskripsi' => $layanan->deskripsi,
                        'persyaratan' => $layanan->persyaratan,
                        'prosedur' => $layanan->prosedur,
                        'biaya' => $layanan->biaya,
                        'waktu_penyelesaian' => $layanan->waktu_penyelesaian,
                        'dasar_hukum' => $layanan->dasar_hukum,
                        'output_layanan' => $layanan->output_layanan,
                        'penanggung_jawab' => $layanan->penanggung_jawab,
                        'kontak' => $layanan->kontak,
                        'formulir_url' => $layanan->formulir_url,
                        'status' => $layanan->status,
                        'urutan' => $layanan->urutan,
                    ]
                ]);
            }

            return view('admin.layanan.edit', compact('layanan'));

        } catch (\Exception $e) {
            Log::error('Error in LayananController@edit: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.layanan')
                ->with('error', 'Layanan tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            $validated = $request->validate([
                'kode_layanan' => 'nullable|string|max:20|unique:layanan,kode_layanan,' . $id,
                'nama_layanan' => 'required|string|max:200',
                'deskripsi' => 'required|string',
                'persyaratan' => 'required|string',
                'prosedur' => 'required|string',
                'biaya' => 'nullable|string|max:50',
                'waktu_penyelesaian' => 'nullable|string|max:50',
                'dasar_hukum' => 'nullable|string',
                'output_layanan' => 'nullable|string|max:200',
                'penanggung_jawab' => 'required|string|max:100',
                'kontak' => 'nullable|string|max:50',
                'formulir_url' => 'nullable|url',
                'status' => 'required|in:aktif,tidak_aktif',
                'urutan' => 'nullable|integer|min:0',
            ]);

            $data = [
                'kode_layanan' => $validated['kode_layanan'],
                'nama_layanan' => $validated['nama_layanan'],
                'slug' => Str::slug($validated['nama_layanan']),
                'deskripsi' => $validated['deskripsi'],
                'persyaratan' => $validated['persyaratan'],
                'prosedur' => $validated['prosedur'],
                'biaya' => $validated['biaya'] ?: 'Gratis',
                'waktu_penyelesaian' => $validated['waktu_penyelesaian'] ?: '1-3 Hari Kerja',
                'dasar_hukum' => $validated['dasar_hukum'],
                'output_layanan' => $validated['output_layanan'],
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'kontak' => $validated['kontak'],
                'formulir_url' => $validated['formulir_url'],
                'status' => $validated['status'],
                'urutan' => $validated['urutan'] ?: 0,
            ];

            $layanan->update($data);
            Log::info('Layanan updated successfully', ['id' => $layanan->id, 'nama_layanan' => $layanan->nama_layanan]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Layanan berhasil diperbarui.',
                    'data' => $layanan
                ]);
            }

            return redirect()->route('admin.layanan')
                ->with('success', 'Layanan berhasil diperbarui.');

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
            Log::error('Error in LayananController@update: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.layanan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            $namaLayanan = $layanan->nama_layanan;
            $layanan->delete();
            Log::info('Layanan deleted successfully', ['id' => $id, 'nama_layanan' => $namaLayanan]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Layanan berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.layanan')
                ->with('success', 'Layanan berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in LayananController@destroy: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.layanan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update status layanan
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $layanan = Layanan::findOrFail($id);
            
            $layanan->update([
                'status' => $request->status
            ]);

            Log::info('Layanan status updated', ['id' => $id, 'status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status layanan berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in LayananController@updateStatus: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete layanan
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada layanan yang dipilih.'
                ], 400);
            }

            // Delete records
            Layanan::whereIn('id', $ids)->delete();
            Log::info('Bulk delete layanan completed', ['count' => count($ids), 'ids' => $ids]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' layanan berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in LayananController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reorder layanan
     */
    public function reorder(Request $request)
    {
        try {
            $items = $request->input('items', []);

            foreach ($items as $index => $id) {
                Layanan::where('id', $id)->update(['urutan' => $index + 1]);
            }

            Log::info('Layanan reordered successfully', ['items' => $items]);

            return response()->json([
                'success' => true,
                'message' => 'Urutan layanan berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in LayananController@reorder: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}