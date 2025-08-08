<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $agenda = Agenda::with('admin')
                ->latest('tanggal_mulai')
                ->paginate(10);

            // Return ke view terpadu dengan variable $agenda (untuk list)
            return view('admin.agenda', compact('agenda'));
        } catch (\Exception $e) {
            Log::error('Error in AgendaController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data agenda.');
        }
    }

    /**
     * Display the specified resource (Detail).
     */
    public function show($id)
    {
        try {
            $agenda_detail = Agenda::with('admin')->findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $agenda_detail->id,
                        'judul' => $agenda_detail->judul,
                        'deskripsi' => $agenda_detail->deskripsi,
                        'tanggal_mulai' => $agenda_detail->tanggal_mulai->format('Y-m-d'),
                        'tanggal_selesai' => $agenda_detail->tanggal_selesai ? $agenda_detail->tanggal_selesai->format('Y-m-d') : null,
                        'waktu_mulai' => $agenda_detail->waktu_mulai,
                        'waktu_selesai' => $agenda_detail->waktu_selesai,
                        'lokasi' => $agenda_detail->lokasi,
                        'kategori' => $agenda_detail->kategori,
                        'status' => $agenda_detail->status,
                        'peserta_target' => $agenda_detail->peserta_target,
                        'biaya' => $agenda_detail->biaya,
                        'penanggung_jawab' => $agenda_detail->penanggung_jawab,
                        'kontak_person' => $agenda_detail->kontak_person,
                        'gambar' => $agenda_detail->gambar,
                        'alt_gambar' => $agenda_detail->alt_gambar,
                        'slug' => $agenda_detail->slug,
                        'admin' => $agenda_detail->admin ? $agenda_detail->admin->nama_lengkap : 'Unknown',
                        'created_at' => $agenda_detail->created_at->format('d/m/Y H:i'),
                        'updated_at' => $agenda_detail->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            // Return ke view terpadu dengan variable $agenda_detail (untuk detail)
            return view('admin.agenda', compact('agenda_detail'));

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@show: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Agenda tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.agenda')
                ->with('error', 'Agenda tidak ditemukan.');
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
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
                'lokasi' => 'nullable|string|max:200',
                'kategori' => 'required|string|max:50',
                'status' => 'required|in:planned,ongoing,completed,cancelled',
                'peserta_target' => 'nullable|integer|min:0',
                'biaya' => 'nullable|numeric|min:0',
                'penanggung_jawab' => 'nullable|string|max:100',
                'kontak_person' => 'nullable|string|max:20',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alt_gambar' => 'nullable|string|max:255',
            ]);

            // Prepare data
            $data = [
                'judul' => $validated['judul'],
                'slug' => Str::slug($validated['judul']),
                'deskripsi' => $validated['deskripsi'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'lokasi' => $validated['lokasi'],
                'kategori' => $validated['kategori'],
                'status' => $validated['status'],
                'peserta_target' => $validated['peserta_target'],
                'biaya' => $validated['biaya'] ?? 0,
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'kontak_person' => $validated['kontak_person'],
                'alt_gambar' => $validated['alt_gambar'],
                'admin_id' => Auth::guard('admin')->id(),
            ];

            // Handle file upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads/agenda
                $destinationPath = public_path('uploads/agenda');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = asset('uploads/agenda/' . $filename);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            // Create agenda
            $agenda = Agenda::create($data);

            if ($agenda) {
                Log::info('Agenda created successfully', ['id' => $agenda->id, 'judul' => $agenda->judul]);
                return redirect()->route('admin.agenda')
                    ->with('success', 'Agenda berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan agenda.')
                    ->withInput();
            }

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data yang dimasukkan tidak valid.');
        } catch (\Exception $e) {
            Log::error('Error in AgendaController@store: ' . $e->getMessage(), [
                'request_data' => $request->except(['gambar']),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $agenda = Agenda::findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $agenda->id,
                        'judul' => $agenda->judul,
                        'deskripsi' => $agenda->deskripsi,
                        'tanggal_mulai' => $agenda->tanggal_mulai->format('Y-m-d'),
                        'tanggal_selesai' => $agenda->tanggal_selesai ? $agenda->tanggal_selesai->format('Y-m-d') : null,
                        'waktu_mulai' => $agenda->waktu_mulai,
                        'waktu_selesai' => $agenda->waktu_selesai,
                        'lokasi' => $agenda->lokasi,
                        'kategori' => $agenda->kategori,
                        'status' => $agenda->status,
                        'peserta_target' => $agenda->peserta_target,
                        'biaya' => $agenda->biaya,
                        'penanggung_jawab' => $agenda->penanggung_jawab,
                        'kontak_person' => $agenda->kontak_person,
                        'gambar' => $agenda->gambar,
                        'alt_gambar' => $agenda->alt_gambar,
                    ]
                ]);
            }

            // Jika bukan AJAX, bisa redirect atau return view (sesuai kebutuhan)
            return redirect()->route('admin.agenda');

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@edit: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Agenda tidak ditemukan'
                ], 404);
            }

            return redirect()->route('admin.agenda')
                ->with('error', 'Agenda tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $agenda = Agenda::findOrFail($id);

            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_selesai' => 'nullable|date_format:H:i',
                'lokasi' => 'nullable|string|max:200',
                'kategori' => 'required|string|max:50',
                'status' => 'required|in:planned,ongoing,completed,cancelled',
                'peserta_target' => 'nullable|integer|min:0',
                'biaya' => 'nullable|numeric|min:0',
                'penanggung_jawab' => 'nullable|string|max:100',
                'kontak_person' => 'nullable|string|max:20',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alt_gambar' => 'nullable|string|max:255',
            ]);

            $data = [
                'judul' => $validated['judul'],
                'slug' => Str::slug($validated['judul']),
                'deskripsi' => $validated['deskripsi'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'waktu_mulai' => $validated['waktu_mulai'],
                'waktu_selesai' => $validated['waktu_selesai'],
                'lokasi' => $validated['lokasi'],
                'kategori' => $validated['kategori'],
                'status' => $validated['status'],
                'peserta_target' => $validated['peserta_target'],
                'biaya' => $validated['biaya'] ?? 0,
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'kontak_person' => $validated['kontak_person'],
                'alt_gambar' => $validated['alt_gambar'],
            ];

            // Handle file upload hanya jika ada file baru
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($agenda->gambar && strpos($agenda->gambar, 'default-') === false) {
                    $oldImagePath = str_replace(asset('uploads/agenda/'), '', $agenda->gambar);
                    $oldImageFullPath = public_path('uploads/agenda/' . $oldImagePath);
                    if (file_exists($oldImageFullPath)) {
                        unlink($oldImageFullPath);
                        Log::info('Old agenda image deleted: ' . $oldImageFullPath);
                    }
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();

                // Upload langsung ke folder public/uploads/agenda
                $destinationPath = public_path('uploads/agenda');

                // Pastikan folder ada
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $uploaded = $file->move($destinationPath, $filename);

                if ($uploaded) {
                    $data['gambar'] = asset('uploads/agenda/' . $filename);
                    Log::info('New agenda image uploaded: ' . $filename);
                } else {
                    return redirect()->back()
                        ->with('error', 'Gagal mengupload gambar.')
                        ->withInput();
                }
            }

            $agenda->update($data);
            Log::info('Agenda updated successfully', ['id' => $agenda->id, 'judul' => $agenda->judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Agenda berhasil diperbarui.',
                    'data' => $agenda
                ]);
            }

            return redirect()->route('admin.agenda')
                ->with('success', 'Agenda berhasil diperbarui.');

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
            Log::error('Error in AgendaController@update: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.agenda')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $agenda = Agenda::findOrFail($id);

            // Delete image file if exists
            if ($agenda->gambar && strpos($agenda->gambar, 'default-') === false) {
                $imagePath = str_replace(asset('uploads/agenda/'), '', $agenda->gambar);
                $imageFullPath = public_path('uploads/agenda/' . $imagePath);
                if (file_exists($imageFullPath)) {
                    unlink($imageFullPath);
                    Log::info('Agenda image deleted: ' . $imageFullPath);
                }
            }

            $judul = $agenda->judul;
            $agenda->delete();
            Log::info('Agenda deleted successfully', ['id' => $id, 'judul' => $judul]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Agenda berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.agenda')
                ->with('success', 'Agenda berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@destroy: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.agenda')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get agenda by kategori
     */
    public function getByKategori($kategori)
    {
        try {
            $agenda = Agenda::where('kategori', $kategori)
                ->latest('tanggal_mulai')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $agenda
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@getByKategori: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get upcoming agenda
     */
    public function getUpcoming()
    {
        try {
            $agenda = Agenda::upcoming()
                ->where('status', '!=', 'cancelled')
                ->latest('tanggal_mulai')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $agenda
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@getUpcoming: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete agenda
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada agenda yang dipilih.'
                ], 400);
            }

            $agenda = Agenda::whereIn('id', $ids)->get();

            // Delete images
            foreach ($agenda as $item) {
                if ($item->gambar && strpos($item->gambar, 'default-') === false) {
                    $imagePath = str_replace(asset('uploads/agenda/'), '', $item->gambar);
                    $imageFullPath = public_path('uploads/agenda/' . $imagePath);
                    if (file_exists($imageFullPath)) {
                        unlink($imageFullPath);
                    }
                }
            }

            // Delete records
            Agenda::whereIn('id', $ids)->delete();
            Log::info('Bulk delete agenda completed', ['count' => count($ids), 'ids' => $ids]);

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' agenda berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AgendaController@bulkDelete: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}