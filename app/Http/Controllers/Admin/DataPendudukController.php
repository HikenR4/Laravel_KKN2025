<?php

// File: app/Http/Controllers/Admin/DataPendudukController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPenduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Debug log
            Log::info('DataPendudukController@index called');
            Log::info('Request URL: ' . $request->url());

            if ($request->ajax()) {
                return $this->getDataAjax($request);
            }

            $query = DataPenduduk::query();

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan jenis kelamin
            if ($request->filled('jenis_kelamin')) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            }

            // Filter berdasarkan RT
            if ($request->filled('rt')) {
                $query->where('rt', $request->rt);
            }

            // Filter berdasarkan RW
            if ($request->filled('rw')) {
                $query->where('rw', $request->rw);
            }

            // Filter berdasarkan pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
                });
            }

            $dataPenduduk = $query->orderBy('nama')->paginate(15);

            // Get statistics
            $statistics = $this->getStatistics();
            
            // Get filter options
            $rtOptions = DataPenduduk::whereNotNull('rt')
                ->distinct()
                ->orderBy('rt')
                ->pluck('rt');

            $rwOptions = DataPenduduk::whereNotNull('rw')
                ->distinct()
                ->orderBy('rw')
                ->pluck('rw');

            Log::info('About to return view: admin.datapenduduk');
            return view('admin.datapenduduk', compact('dataPenduduk', 'statistics', 'rtOptions', 'rwOptions'));
            
        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@index: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat memuat data penduduk: ' . $e->getMessage());
        }
    }

    /**
     * Get data for AJAX requests
     */
    private function getDataAjax(Request $request)
    {
        $query = DataPenduduk::query();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $data = $query->orderBy('nama')->paginate($perPage);

        // Transform data
        $data->getCollection()->transform(function ($item) {
            $item->umur = $item->tanggal_lahir ? Carbon::parse($item->tanggal_lahir)->age : 0;
            $item->tempat_tanggal_lahir_formatted = $item->tempat_lahir . ', ' . ($item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '');
            $item->alamat_lengkap = $item->alamat . ' RT ' . $item->rt . ' RW ' . $item->rw;
            $item->jenis_kelamin_text = $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'nik' => 'required|string|size:16|unique:data_penduduk,nik',
                'nama' => 'required|string|max:100',
                'jenis_kelamin' => 'required|in:L,P',
                'no_kk' => 'nullable|string|size:16',
                'tempat_lahir' => 'nullable|string|max:50',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string',
                'rt' => 'nullable|string|max:5',
                'rw' => 'nullable|string|max:5',
                'agama' => 'nullable|string|max:20',
                'status_perkawinan' => 'nullable|string|max:30',
                'pekerjaan' => 'nullable|string|max:50',
                'pendidikan' => 'nullable|string|max:50',
                'telepon' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:100',
                'nama_ayah' => 'nullable|string|max:100',
                'nama_ibu' => 'nullable|string|max:100',
                'status_hubungan_keluarga' => 'nullable|string|max:50',
                'golongan_darah' => 'nullable|string|max:5',
                'kewarganegaraan' => 'nullable|string|max:10',
            ]);

            // Prepare data
            $data = $validated;
            $data['status'] = 'aktif';
            $data['kewarganegaraan'] = $data['kewarganegaraan'] ?? 'WNI';
            $data['agama'] = $data['agama'] ?? 'Islam';
            $data['status_perkawinan'] = $data['status_perkawinan'] ?? 'Belum Kawin';

            // Create data penduduk
            $penduduk = DataPenduduk::create($data);

            if ($penduduk) {
                Log::info('Data penduduk created successfully', ['id' => $penduduk->id, 'nama' => $penduduk->nama]);
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Data penduduk berhasil ditambahkan.',
                        'data' => $penduduk
                    ]);
                }

                return redirect()->route('admin.datapenduduk')
                    ->with('success', 'Data penduduk berhasil ditambahkan.');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menyimpan data penduduk.'
                    ], 500);
                }

                return redirect()->back()
                    ->with('error', 'Gagal menyimpan data penduduk.')
                    ->withInput();
            }

        } catch (ValidationException $e) {
            if ($request->ajax()) {
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
            Log::error('Error in DataPendudukController@store: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

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
            $penduduk = DataPenduduk::findOrFail($id);

            if (request()->ajax()) {
                // Add calculated fields
                $penduduk->umur = $penduduk->tanggal_lahir ? Carbon::parse($penduduk->tanggal_lahir)->age : 0;
                $penduduk->tempat_tanggal_lahir_formatted = $penduduk->tempat_lahir . ', ' . ($penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d/m/Y') : '');
                $penduduk->alamat_lengkap_formatted = $penduduk->alamat . ' RT ' . $penduduk->rt . ' RW ' . $penduduk->rw;
                $penduduk->jenis_kelamin_text = $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';

                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $penduduk->id,
                        'nik' => $penduduk->nik,
                        'no_kk' => $penduduk->no_kk,
                        'nama' => $penduduk->nama,
                        'tempat_lahir' => $penduduk->tempat_lahir,
                        'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : null,
                        'jenis_kelamin' => $penduduk->jenis_kelamin,
                        'jenis_kelamin_text' => $penduduk->jenis_kelamin_text,
                        'alamat' => $penduduk->alamat,
                        'rt' => $penduduk->rt,
                        'rw' => $penduduk->rw,
                        'agama' => $penduduk->agama,
                        'status_perkawinan' => $penduduk->status_perkawinan,
                        'pekerjaan' => $penduduk->pekerjaan,
                        'pendidikan' => $penduduk->pendidikan,
                        'telepon' => $penduduk->telepon,
                        'email' => $penduduk->email,
                        'nama_ayah' => $penduduk->nama_ayah,
                        'nama_ibu' => $penduduk->nama_ibu,
                        'status_hubungan_keluarga' => $penduduk->status_hubungan_keluarga,
                        'golongan_darah' => $penduduk->golongan_darah,
                        'kewarganegaraan' => $penduduk->kewarganegaraan,
                        'status' => $penduduk->status,
                        'umur' => $penduduk->umur,
                        'tempat_tanggal_lahir_formatted' => $penduduk->tempat_tanggal_lahir_formatted,
                        'alamat_lengkap_formatted' => $penduduk->alamat_lengkap_formatted,
                        'created_at' => $penduduk->created_at->format('d/m/Y H:i'),
                        'updated_at' => $penduduk->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            // Return halaman detail penduduk
            return view('admin.detail-datapenduduk', compact('penduduk'));

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@show: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data penduduk tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('error', 'Data penduduk tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $penduduk = DataPenduduk::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $penduduk->id,
                        'nik' => $penduduk->nik,
                        'no_kk' => $penduduk->no_kk,
                        'nama' => $penduduk->nama,
                        'tempat_lahir' => $penduduk->tempat_lahir,
                        'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('Y-m-d') : null,
                        'jenis_kelamin' => $penduduk->jenis_kelamin,
                        'alamat' => $penduduk->alamat,
                        'rt' => $penduduk->rt,
                        'rw' => $penduduk->rw,
                        'agama' => $penduduk->agama,
                        'status_perkawinan' => $penduduk->status_perkawinan,
                        'pekerjaan' => $penduduk->pekerjaan,
                        'pendidikan' => $penduduk->pendidikan,
                        'telepon' => $penduduk->telepon,
                        'email' => $penduduk->email,
                        'nama_ayah' => $penduduk->nama_ayah,
                        'nama_ibu' => $penduduk->nama_ibu,
                        'status_hubungan_keluarga' => $penduduk->status_hubungan_keluarga,
                        'golongan_darah' => $penduduk->golongan_darah,
                        'kewarganegaraan' => $penduduk->kewarganegaraan,
                        'status' => $penduduk->status,
                    ]
                ]);
            }

            $rtOptions = DataPenduduk::whereNotNull('rt')->distinct()->orderBy('rt')->pluck('rt');
            $rwOptions = DataPenduduk::whereNotNull('rw')->distinct()->orderBy('rw')->pluck('rw');
            
            return view('admin.datapenduduk.edit', compact('penduduk', 'rtOptions', 'rwOptions'));

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@edit: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data penduduk tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('error', 'Data penduduk tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $penduduk = DataPenduduk::findOrFail($id);

            $validated = $request->validate([
                'nik' => 'required|string|size:16|unique:data_penduduk,nik,' . $id,
                'nama' => 'required|string|max:100',
                'jenis_kelamin' => 'required|in:L,P',
                'no_kk' => 'nullable|string|size:16',
                'tempat_lahir' => 'nullable|string|max:50',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string',
                'rt' => 'nullable|string|max:5',
                'rw' => 'nullable|string|max:5',
                'agama' => 'nullable|string|max:20',
                'status_perkawinan' => 'nullable|string|max:30',
                'pekerjaan' => 'nullable|string|max:50',
                'pendidikan' => 'nullable|string|max:50',
                'telepon' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:100',
                'nama_ayah' => 'nullable|string|max:100',
                'nama_ibu' => 'nullable|string|max:100',
                'status_hubungan_keluarga' => 'nullable|string|max:50',
                'golongan_darah' => 'nullable|string|max:5',
                'kewarganegaraan' => 'nullable|string|max:10',
            ]);

            $penduduk->update($validated);
            Log::info('Data penduduk updated successfully', ['id' => $penduduk->id, 'nama' => $penduduk->nama]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data penduduk berhasil diperbarui.',
                    'data' => $penduduk
                ]);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('success', 'Data penduduk berhasil diperbarui.');

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
            Log::error('Error in DataPendudukController@update: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $penduduk = DataPenduduk::findOrFail($id);
            $nama = $penduduk->nama;
            
            $penduduk->delete();
            Log::info('Data penduduk deleted successfully', ['id' => $id, 'nama' => $nama]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data penduduk berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('success', 'Data penduduk berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@destroy: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.datapenduduk')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics data
     */
    private function getStatistics()
    {
        $total = DataPenduduk::where('status', 'aktif')->count();
        $pria = DataPenduduk::where('status', 'aktif')->where('jenis_kelamin', 'L')->count();
        $wanita = DataPenduduk::where('status', 'aktif')->where('jenis_kelamin', 'P')->count();
        $kepala_keluarga = DataPenduduk::where('status', 'aktif')
            ->where('status_hubungan_keluarga', 'Kepala Keluarga')
            ->count();

        return compact('total', 'pria', 'wanita', 'kepala_keluarga');
    }

    /**
     * Update status penduduk (pindah/meninggal)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $penduduk = DataPenduduk::findOrFail($id);
            
            $penduduk->update([
                'status' => $request->status
            ]);

            Log::info('Data penduduk status updated', ['id' => $id, 'status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status penduduk berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@updateStatus: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Implementasi export akan dilakukan sesuai kebutuhan
            return response()->json([
                'success' => false,
                'message' => 'Fitur export akan segera tersedia'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat export data!'
            ], 500);
        }
    }

    /**
     * Get data by RT
     */
    public function getByRT($rt)
    {
        try {
            $penduduk = DataPenduduk::where('rt', $rt)->where('status', 'aktif')->get();

            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@getByRT: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data by RW
     */
    public function getByRW($rw)
    {
        try {
            $penduduk = DataPenduduk::where('rw', $rw)->where('status', 'aktif')->get();

            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@getByRW: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search penduduk
     */
    public function search(Request $request)
    {
        try {
            $search = $request->get('q');
            
            $penduduk = DataPenduduk::where('nama', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->where('status', 'aktif')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $penduduk
            ]);

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@search: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete penduduk
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang dipilih.'
                ], 400);
            }

            DataPenduduk::whereIn('id', $ids)->delete();
            Log::info('Bulk delete data penduduk completed', ['count' => count($ids), 'ids' => $ids]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' data penduduk berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in DataPendudukController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dashboard statistics
     */
    public function statistics()
    {
        try {
            $stats = $this->getStatistics();
            
            // Additional statistics
            $stats['by_age_group'] = [
                'anak' => DataPenduduk::where('status', 'aktif')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 17')
                    ->count(),
                'dewasa' => DataPenduduk::where('status', 'aktif')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 17 AND 59')
                    ->count(),
                'lansia' => DataPenduduk::where('status', 'aktif')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')
                    ->count(),
            ];

            $stats['by_education'] = DataPenduduk::where('status', 'aktif')
                ->select('pendidikan', DB::raw('count(*) as jumlah'))
                ->whereNotNull('pendidikan')
                ->groupBy('pendidikan')
                ->orderBy('jumlah', 'desc')
                ->get();

            $stats['by_rt_rw'] = DataPenduduk::where('status', 'aktif')
                ->select('rt', 'rw', DB::raw('count(*) as jumlah'))
                ->whereNotNull('rt')
                ->whereNotNull('rw')
                ->groupBy('rt', 'rw')
                ->orderBy('rt')
                ->orderBy('rw')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil statistik!'
            ], 500);
        }
    }
}