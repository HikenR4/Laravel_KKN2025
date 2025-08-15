<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananpublicController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk layanan aktif
        $query = Layanan::active()->ordered();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('persyaratan', 'LIKE', "%{$search}%")
                  ->orWhere('prosedur', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori (berdasarkan kata kunci dalam nama)
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;

            // Validasi kategori yang diizinkan
            $allowedCategories = ['surat', 'izin', 'keterangan', 'penduduk'];
            if (!in_array($kategori, $allowedCategories)) {
                // Jika kategori tidak valid, redirect ke halaman layanan dengan pesan error
                return redirect()->route('layanan')->with('error', 'Kategori yang dipilih tidak valid.');
            }

            switch ($kategori) {
                case 'surat':
                    $query->where('nama_layanan', 'LIKE', '%surat%');
                    break;
                case 'izin':
                    $query->where('nama_layanan', 'LIKE', '%izin%');
                    break;
                case 'keterangan':
                    $query->where('nama_layanan', 'LIKE', '%keterangan%');
                    break;
                case 'penduduk':
                    $query->where(function($q) {
                        $q->where('nama_layanan', 'LIKE', '%ktp%')
                          ->orWhere('nama_layanan', 'LIKE', '%kk%')
                          ->orWhere('nama_layanan', 'LIKE', '%penduduk%');
                    });
                    break;
            }
        }

        // Filter berdasarkan biaya
        if ($request->filled('biaya')) {
            $biaya = $request->biaya;

            // Validasi filter biaya yang diizinkan
            $allowedBiayaFilters = ['gratis', 'berbayar'];
            if (!in_array($biaya, $allowedBiayaFilters)) {
                return redirect()->route('layanan')->with('error', 'Filter biaya yang dipilih tidak valid.');
            }

            switch ($biaya) {
                case 'gratis':
                    $query->where(function($q) {
                        $q->where('biaya', 'LIKE', '%gratis%')
                          ->orWhere('biaya', 'LIKE', '%tidak ada%')
                          ->orWhere('biaya', 'LIKE', '%0%')
                          ->orWhereNull('biaya')
                          ->orWhere('biaya', '');
                    });
                    break;
                case 'berbayar':
                    $query->where('biaya', 'NOT LIKE', '%gratis%')
                          ->where('biaya', 'NOT LIKE', '%tidak ada%')
                          ->whereNotNull('biaya')
                          ->where('biaya', '!=', '')
                          ->where('biaya', 'NOT LIKE', '%0%');
                    break;
            }
        }

        // Pagination
        $layanan = $query->paginate(12);

        // Data untuk kategori
        $categories = [
            'surat' => 'Pelayanan Surat',
            'izin' => 'Pelayanan Izin',
            'keterangan' => 'Surat Keterangan',
            'penduduk' => 'Kependudukan'
        ];

        // Data untuk filter biaya
        $biayaOptions = [
            'gratis' => 'Gratis',
            'berbayar' => 'Berbayar'
        ];

        // Statistik
        $totalLayanan = Layanan::active()->count();
        $layananGratis = Layanan::active()
            ->where(function($q) {
                $q->where('biaya', 'LIKE', '%gratis%')
                  ->orWhere('biaya', 'LIKE', '%tidak ada%')
                  ->orWhereNull('biaya')
                  ->orWhere('biaya', '');
            })->count();

        // Layanan populer (berdasarkan urutan teratas)
        $layananPopuler = Layanan::active()
            ->ordered()
            ->take(6)
            ->get();

        // Hitung kategori dengan jumlah
        $categoriesWithCounts = [];
        foreach ($categories as $key => $label) {
            $count = 0;
            switch ($key) {
                case 'surat':
                    $count = Layanan::active()->where('nama_layanan', 'LIKE', '%surat%')->count();
                    break;
                case 'izin':
                    $count = Layanan::active()->where('nama_layanan', 'LIKE', '%izin%')->count();
                    break;
                case 'keterangan':
                    $count = Layanan::active()->where('nama_layanan', 'LIKE', '%keterangan%')->count();
                    break;
                case 'penduduk':
                    $count = Layanan::active()->where(function($q) {
                        $q->where('nama_layanan', 'LIKE', '%ktp%')
                          ->orWhere('nama_layanan', 'LIKE', '%kk%')
                          ->orWhere('nama_layanan', 'LIKE', '%penduduk%');
                    })->count();
                    break;
            }
            $categoriesWithCounts[$key] = [
                'label' => $label,
                'count' => $count
            ];
        }

        return view('public.layanan', compact(
            'layanan',
            'categories',
            'biayaOptions',
            'totalLayanan',
            'layananGratis',
            'layananPopuler',
            'categoriesWithCounts'
        ));
    }

    public function show($slug)
    {
        $layanan = Layanan::where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        // Layanan terkait (berdasarkan kata kunci nama)
        $keywords = explode(' ', $layanan->nama_layanan);
        $layananTerkait = Layanan::active()
            ->where('id', '!=', $layanan->id)
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 3) { // Hanya kata dengan panjang > 3
                        $query->orWhere('nama_layanan', 'LIKE', "%{$keyword}%");
                    }
                }
            })
            ->take(4)
            ->get();

        // Increment view count jika ada field untuk tracking
        // $layanan->increment('views');

        return view('public.layanan-detail', compact('layanan', 'layananTerkait'));
    }

    public function kategori($kategori, Request $request)
    {
        // Validasi kategori
        $allowedCategories = ['surat', 'izin', 'keterangan', 'penduduk'];
        if (!in_array($kategori, $allowedCategories)) {
            return redirect()->route('layanan')->with('error', 'Kategori yang dipilih tidak tersedia.');
        }

        $request->merge(['kategori' => $kategori]);
        return $this->index($request);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100'
        ]);

        $request->merge(['search' => $request->q]);
        return $this->index($request);
    }
}
