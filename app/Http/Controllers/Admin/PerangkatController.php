<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatNagari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PerangkatController extends Controller
{
    public function index(Request $request)
    {
        $query = PerangkatNagari::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan', 'like', '%' . $request->jabatan . '%');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }

        $perangkats = $query->ordered()->paginate(10)->withQueryString();

        return view('admin.perangkat', compact('perangkats'));
    }

    public function detail($id)
    {
        try {
            $perangkat = PerangkatNagari::findOrFail($id);
            return view('admin.detail-perangkat', compact('perangkat'));
        } catch (\Exception $e) {
            Log::error('Error loading perangkat detail: ' . $e->getMessage());
            return redirect()->route('admin.perangkat')
                ->with('error', 'Data perangkat tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50|unique:perangkat_nagari,nip',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:50',
            'masa_jabatan_mulai' => 'nullable|date',
            'masa_jabatan_selesai' => 'nullable|date|after_or_equal:masa_jabatan_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'email.email' => 'Format email tidak valid',
            'masa_jabatan_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus aktif atau nonaktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang diinput.');
        }

        try {
            $data = $validator->validated();

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->uploadFoto($request->file('foto'));
            }

            // Set urutan default jika tidak diisi
            if (!isset($data['urutan']) || empty($data['urutan'])) {
                $data['urutan'] = PerangkatNagari::getNextUrutan();
            }

            PerangkatNagari::create($data);

            return redirect()->route('admin.perangkat')
                ->with('success', 'Data perangkat nagari berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Error creating perangkat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data perangkat nagari: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $perangkat = PerangkatNagari::findOrFail($id);

            // Perbaiki foto URL untuk AJAX response
            $fotoUrl = null;
            if ($perangkat->getRawOriginal('foto')) {
                $fotoUrl = asset('uploads/perangkat/' . $perangkat->getRawOriginal('foto'));
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $perangkat->id,
                    'nama' => $perangkat->nama,
                    'jabatan' => $perangkat->jabatan,
                    'nip' => $perangkat->nip,
                    'foto' => $fotoUrl,
                    'telepon' => $perangkat->telepon,
                    'email' => $perangkat->email,
                    'alamat' => $perangkat->alamat,
                    'pendidikan' => $perangkat->pendidikan,
                    'masa_jabatan_mulai' => $perangkat->masa_jabatan_mulai?->format('Y-m-d'),
                    'masa_jabatan_selesai' => $perangkat->masa_jabatan_selesai?->format('Y-m-d'),
                    'status' => $perangkat->status,
                    'urutan' => $perangkat->urutan,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data perangkat nagari tidak ditemukan.'
            ], 404);
        }
    }

    public function edit($id)
    {
        try {
            $perangkat = PerangkatNagari::findOrFail($id);

            // Perbaiki foto URL untuk AJAX response
            $fotoUrl = null;
            if ($perangkat->getRawOriginal('foto')) {
                $fotoUrl = asset('uploads/perangkat/' . $perangkat->getRawOriginal('foto'));
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $perangkat->id,
                    'nama' => $perangkat->nama,
                    'jabatan' => $perangkat->jabatan,
                    'nip' => $perangkat->nip,
                    'foto' => $fotoUrl,
                    'telepon' => $perangkat->telepon,
                    'email' => $perangkat->email,
                    'alamat' => $perangkat->alamat,
                    'pendidikan' => $perangkat->pendidikan,
                    'masa_jabatan_mulai' => $perangkat->masa_jabatan_mulai?->format('Y-m-d'),
                    'masa_jabatan_selesai' => $perangkat->masa_jabatan_selesai?->format('Y-m-d'),
                    'status' => $perangkat->status,
                    'urutan' => $perangkat->urutan,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data perangkat nagari tidak ditemukan.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $perangkat = PerangkatNagari::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50|unique:perangkat_nagari,nip,' . $id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:50',
            'masa_jabatan_mulai' => 'nullable|date',
            'masa_jabatan_selesai' => 'nullable|date|after_or_equal:masa_jabatan_mulai',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'nip.unique' => 'NIP sudah digunakan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'email.email' => 'Format email tidak valid',
            'masa_jabatan_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'status.required' => 'Status wajib dipilih'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang diinput.');
        }

        try {
            $data = $validator->validated();

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                $oldFoto = $perangkat->getRawOriginal('foto');
                if ($oldFoto) {
                    $this->deleteFoto($oldFoto);
                }
                // Upload foto baru
                $data['foto'] = $this->uploadFoto($request->file('foto'));
            }

            $perangkat->update($data);

            // Cek jika request dari detail page
            if ($request->has('from_detail')) {
                return redirect()->route('admin.perangkat.detail', $id)
                    ->with('success', 'Data perangkat nagari berhasil diperbarui.');
            }

            return redirect()->route('admin.perangkat')
                ->with('success', 'Data perangkat nagari berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating perangkat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data perangkat nagari: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $perangkat = PerangkatNagari::findOrFail($id);

            // Hapus foto jika ada
            $oldFoto = $perangkat->getRawOriginal('foto');
            if ($oldFoto) {
                $this->deleteFoto($oldFoto);
            }

            $perangkat->delete();

            return redirect()->route('admin.perangkat')
                ->with('success', 'Data perangkat nagari berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting perangkat: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus data perangkat nagari: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $perangkat = PerangkatNagari::findOrFail($id);
            $perangkat->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status perangkat nagari berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status perangkat nagari.'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->ids;

            if (!is_array($ids) || empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang dipilih untuk dihapus.'
                ], 400);
            }

            $perangkats = PerangkatNagari::whereIn('id', $ids)->get();

            foreach ($perangkats as $perangkat) {
                // Hapus foto jika ada
                $oldFoto = $perangkat->getRawOriginal('foto');
                if ($oldFoto) {
                    $this->deleteFoto($oldFoto);
                }
                $perangkat->delete();
            }

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' data perangkat nagari berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data perangkat nagari: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        try {
            $orders = $request->orders;

            if (!is_array($orders)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data urutan tidak valid.'
                ], 400);
            }

            foreach ($orders as $order) {
                if (isset($order['id']) && isset($order['urutan'])) {
                    PerangkatNagari::where('id', $order['id'])
                        ->update(['urutan' => $order['urutan']]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan perangkat nagari berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan perangkat nagari: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload foto ke direktori public/uploads/perangkat
     */
    private function uploadFoto($file)
    {
        try {
            $uploadPath = public_path('uploads/perangkat');

            // Buat direktori jika belum ada
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
                Log::info('Created directory: ' . $uploadPath);
            }

            // Generate nama file unik
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Coba upload file
            $filePath = $uploadPath . '/' . $filename;

            if ($file->move($uploadPath, $filename)) {
                Log::info('File uploaded successfully: ' . $filePath);

                // Verifikasi file ada
                if (File::exists($filePath)) {
                    Log::info('File verified exists: ' . $filePath);
                    return $filename;
                } else {
                    Log::error('File upload failed - file not found after move: ' . $filePath);
                    throw new \Exception('File tidak ditemukan setelah upload');
                }
            } else {
                Log::error('File move failed');
                throw new \Exception('Gagal memindahkan file');
            }

        } catch (\Exception $e) {
            Log::error('Error uploading foto: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Hapus foto dari direktori
     */
    private function deleteFoto($filename)
    {
        try {
            if ($filename && $filename !== 'default-avatar.png') {
                $fotoPath = public_path('uploads/perangkat/' . $filename);
                if (File::exists($fotoPath)) {
                    File::delete($fotoPath);
                    Log::info('Deleted foto: ' . $fotoPath);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error deleting foto: ' . $e->getMessage());
        }
    }
}
