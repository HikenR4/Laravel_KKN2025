<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\DataPenduduk;
use App\Models\Agenda;
use App\Models\ProfilNagari;
use App\Models\PerangkatNagari;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Definisi kategori berita yang tersedia
    private $availableCategories = [
        'umum' => 'Umum',
        'pemerintahan' => 'Pemerintahan',
        'ekonomi' => 'Ekonomi',
        'sosial' => 'Sosial',
        'budaya' => 'Budaya',
        'kesehatan' => 'Kesehatan',
        'pendidikan' => 'Pendidikan',
        'olahraga' => 'Olahraga'
    ];

    // Definisi kategori agenda yang tersedia
    private $availableAgendaCategories = [
        'rapat' => 'Rapat',
        'sosialisasi' => 'Sosialisasi',
        'pelatihan' => 'Pelatihan',
        'gotong-royong' => 'Gotong Royong',
        'keagamaan' => 'Keagamaan',
        'olahraga' => 'Olahraga',
        'budaya' => 'Budaya',
        'lainnya' => 'Lainnya'
    ];

    public function landing()
    {
        return view('public.landing');
    }

    public function berita(Request $request)
    {
        $query = Berita::published()->with('admin')->latest('tanggal');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Get berita with pagination
        $berita = $query->paginate(9);

        // Get all available categories
        $categories = collect($this->availableCategories);

        // Get category counts for sidebar
        $categoryCounts = Berita::published()
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to categories
        $categoriesWithCounts = $categories->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get total published berita count
        $totalBerita = Berita::published()->count();

        // Get featured berita
        $featuredBerita = Berita::published()
            ->featured()
            ->latest('tanggal')
            ->take(3)
            ->get();

        return view('public.berita', compact(
            'berita',
            'categories',
            'categoriesWithCounts',
            'totalBerita',
            'featuredBerita'
        ));
    }

    public function beritaDetail($slug)
    {
        try {
            // Get the main berita with relationships
            $berita = Berita::published()
                ->with(['admin', 'komentarAktif'])
                ->where('slug', $slug)
                ->firstOrFail();

            // Increment views
            $berita->increment('views');

            // Get related berita (same category, exclude current)
            $relatedBerita = Berita::published()
                ->where('kategori', $berita->kategori)
                ->where('id', '!=', $berita->id)
                ->latest('tanggal')
                ->take(3)
                ->get();

            // Get latest berita for sidebar
            $latestBerita = Berita::published()
                ->where('id', '!=', $berita->id)
                ->latest('tanggal')
                ->take(5)
                ->get();

            // Get popular berita (by views) for sidebar
            $popularBerita = Berita::published()
                ->where('id', '!=', $berita->id)
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();

            // Get total published berita count for categories widget
            $totalBerita = Berita::published()->count();

            // Get category counts for sidebar
            $categoryCounts = Berita::published()
                ->selectRaw('kategori, COUNT(*) as count')
                ->groupBy('kategori')
                ->pluck('count', 'kategori');

            // Get all available categories for sidebar
            $categories = collect($this->availableCategories);

            return view('public.detail-berita', compact(
                'berita',
                'relatedBerita',
                'latestBerita',
                'popularBerita',
                'totalBerita',
                'categoryCounts',
                'categories'
            ));

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error loading berita detail: ' . $e->getMessage());
            
            // Redirect with error message
            return redirect()->route('berita')
                ->with('error', 'Berita yang Anda cari tidak ditemukan.');
        }
    }

    public function beritaByKategori($kategori)
    {
        // Validasi kategori
        if (!array_key_exists($kategori, $this->availableCategories)) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $berita = Berita::published()
            ->with('admin')
            ->where('kategori', $kategori)
            ->latest('tanggal')
            ->paginate(9);

        // Get all available categories
        $categories = collect($this->availableCategories);

        // Get category counts for sidebar
        $categoryCounts = Berita::published()
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to categories
        $categoriesWithCounts = $categories->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get total published berita count
        $totalBerita = Berita::published()->count();
        $featuredBerita = collect(); // Empty collection for category pages

        return view('public.berita', compact(
            'berita',
            'categories',
            'categoriesWithCounts',
            'totalBerita',
            'featuredBerita'
        ))
        ->with('selectedKategori', $kategori)
        ->with('selectedKategoriLabel', $this->availableCategories[$kategori]);
    }

    public function home()
    {
        // Ambil data dari database untuk homepage
        $berita = Berita::published()->latest('tanggal')->take(3)->get();
        $pengumuman = Pengumuman::active()->latest('tanggal_mulai')->take(3)->get();
        $agenda = Agenda::upcoming()->latest('tanggal_mulai')->take(3)->get();

        // Data statistik
        $totalPenduduk = DataPenduduk::active()->count();
        $totalKK = DataPenduduk::active()->distinct('no_kk')->count('no_kk');
        $totalPria = DataPenduduk::active()->pria()->count();
        $totalWanita = DataPenduduk::active()->wanita()->count();

        return view('public.home', compact(
            'berita',
            'pengumuman',
            'agenda',
            'totalPenduduk',
            'totalKK',
            'totalPria',
            'totalWanita'
        ));
    }

    /**
     * Get available categories
     */
    public function getAvailableCategories()
    {
        return $this->availableCategories;
    }

    /**
     * Get category label by key
     */
    public function getCategoryLabel($key)
    {
        return $this->availableCategories[$key] ?? ucfirst($key);
    }

    /**
     * Search berita by keyword
     */
    public function searchBerita(Request $request)
    {
        $keyword = $request->get('q', '');
        
        if (empty($keyword)) {
            return redirect()->route('berita');
        }

        $berita = Berita::published()
            ->with('admin')
            ->where(function($query) use ($keyword) {
                $query->where('judul', 'like', '%' . $keyword . '%')
                      ->orWhere('konten', 'like', '%' . $keyword . '%')
                      ->orWhere('excerpt', 'like', '%' . $keyword . '%')
                      ->orWhere('tags', 'like', '%' . $keyword . '%');
            })
            ->latest('tanggal')
            ->paginate(9);

        // Get all available categories
        $categories = collect($this->availableCategories);

        // Get category counts for sidebar
        $categoryCounts = Berita::published()
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to categories
        $categoriesWithCounts = $categories->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get total published berita count
        $totalBerita = Berita::published()->count();
        $featuredBerita = collect(); // Empty for search results

        return view('public.berita', compact(
            'berita',
            'categories',
            'categoriesWithCounts',
            'totalBerita',
            'featuredBerita'
        ))->with('searchKeyword', $keyword);
    }

    /**
     * Get berita by tag
     */
    public function beritaByTag($tag)
    {
        $berita = Berita::published()
            ->with('admin')
            ->where('tags', 'like', '%' . $tag . '%')
            ->latest('tanggal')
            ->paginate(9);

        // Get all available categories
        $categories = collect($this->availableCategories);

        // Get category counts for sidebar
        $categoryCounts = Berita::published()
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to categories
        $categoriesWithCounts = $categories->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get total published berita count
        $totalBerita = Berita::published()->count();
        $featuredBerita = collect(); // Empty for tag results

        return view('public.berita', compact(
            'berita',
            'categories',
            'categoriesWithCounts',
            'totalBerita',
            'featuredBerita'
        ))->with('selectedTag', $tag);
    }

    public function agenda(Request $request)
    {
        $query = Agenda::with('admin')
            ->where('status', '!=', 'cancelled')
            ->latest('tanggal_mulai');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('tanggal') && $request->tanggal != '') {
            $tanggal = $request->tanggal;
            if ($tanggal === 'upcoming') {
                $query->upcoming();
            } elseif ($tanggal === 'past') {
                $query->past();
            } elseif ($tanggal === 'today') {
                $query->whereDate('tanggal_mulai', Carbon::today());
            }
        }

        // Get agenda with pagination
        $agenda = $query->paginate(12);

        // Get available categories - ALWAYS show ALL categories
        $categories = $this->availableAgendaCategories;

        // Get category counts for ALL categories
        $categoryCounts = Agenda::where('status', '!=', 'cancelled')
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to ALL categories (show 0 if no agenda exists)
        $categoriesWithCounts = collect($categories)->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get upcoming agenda for sidebar
        $upcomingAgenda = Agenda::upcoming()
            ->where('status', '!=', 'cancelled')
            ->latest('tanggal_mulai')
            ->take(5)
            ->get();

        // Get featured/important agenda
        $featuredAgenda = Agenda::upcoming()
            ->where('status', 'planned')
            ->where('peserta_target', '>', 50) // Consider as featured if target > 50
            ->latest('tanggal_mulai')
            ->take(3)
            ->get();

        return view('public.agenda', compact(
            'agenda',
            'categories',
            'categoriesWithCounts',
            'upcomingAgenda',
            'featuredAgenda'
        ));
    }

    public function agendaDetail($slug)
    {
        try {
            // Get the main agenda
            $agenda = Agenda::with('admin')
                ->where('slug', $slug)
                ->where('status', '!=', 'cancelled')
                ->firstOrFail();

            // Get related agenda (same category, exclude current)
            $relatedAgenda = Agenda::where('kategori', $agenda->kategori)
                ->where('id', '!=', $agenda->id)
                ->where('status', '!=', 'cancelled')
                ->latest('tanggal_mulai')
                ->take(3)
                ->get();

            // Get upcoming agenda for sidebar
            $upcomingAgenda = Agenda::upcoming()
                ->where('id', '!=', $agenda->id)
                ->where('status', '!=', 'cancelled')
                ->latest('tanggal_mulai')
                ->take(5)
                ->get();

            return view('public.detail-agenda', compact(
                'agenda',
                'relatedAgenda',
                'upcomingAgenda'
            ));

        } catch (\Exception $e) {
            return redirect()->route('agenda')
                ->with('error', 'Agenda yang Anda cari tidak ditemukan.');
        }
    }

    public function agendaByKategori($kategori)
    {
        // Validate category
        if (!array_key_exists($kategori, $this->availableAgendaCategories)) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $agenda = Agenda::with('admin')
            ->where('kategori', $kategori)
            ->where('status', '!=', 'cancelled')
            ->latest('tanggal_mulai')
            ->paginate(12);

        // Get categories with counts - ALWAYS show ALL categories
        $categoryCounts = Agenda::where('status', '!=', 'cancelled')
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        $categoriesWithCounts = collect($this->availableAgendaCategories)->map(function($label, $key) use ($categoryCounts) {
            return [
                'label' => $label,
                'count' => $categoryCounts->get($key, 0)
            ];
        });

        // Get upcoming agenda for sidebar
        $upcomingAgenda = Agenda::upcoming()
            ->where('status', '!=', 'cancelled')
            ->latest('tanggal_mulai')
            ->take(5)
            ->get();

        $featuredAgenda = collect(); // Empty for category pages

        return view('public.agenda', compact(
            'agenda',
            'categoriesWithCounts',
            'upcomingAgenda',
            'featuredAgenda'
        ))
        ->with('selectedKategori', $kategori)
        ->with('selectedKategoriLabel', $this->availableAgendaCategories[$kategori]);
    }

    /**
     * Halaman Tentang
     */
    public function tentang()
    {
        try {
            // Ambil profil nagari
            $profil = ProfilNagari::first();

            // Ambil perangkat nagari aktif berdasarkan urutan
            $perangkat = PerangkatNagari::active()->ordered()->get();

            // Ambil layanan aktif
            $layanan = Layanan::active()->ordered()->get();

            // Statistik penduduk
            $statistikPenduduk = [
                'total' => DataPenduduk::active()->count(),
                'pria' => DataPenduduk::active()->pria()->count(),
                'wanita' => DataPenduduk::active()->wanita()->count(),
                'total_kk' => DataPenduduk::active()->distinct('no_kk')
                    ->whereNotNull('no_kk')->count('no_kk'),
            ];

            // Statistik berdasarkan kelompok umur
            $kelompokUmur = [
                'anak' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 17')->count(),
                'dewasa' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 17 AND 60')->count(),
                'lansia' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) > 60')->count(),
            ];

            // Statistik berdasarkan pekerjaan (top 5)
            $statistikPekerjaan = DataPenduduk::active()
                ->selectRaw('pekerjaan, COUNT(*) as jumlah')
                ->whereNotNull('pekerjaan')
                ->where('pekerjaan', '!=', '')
                ->groupBy('pekerjaan')
                ->orderByDesc('jumlah')
                ->limit(5)
                ->get();

            // Statistik berdasarkan pendidikan (top 5)
            $statistikPendidikan = DataPenduduk::active()
                ->selectRaw('pendidikan, COUNT(*) as jumlah')
                ->whereNotNull('pendidikan')
                ->where('pendidikan', '!=', '')
                ->groupBy('pendidikan')
                ->orderByDesc('jumlah')
                ->limit(5)
                ->get();

            return view('public.tentang', compact(
                'profil',
                'perangkat',
                'layanan',
                'statistikPenduduk',
                'kelompokUmur',
                'statistikPekerjaan',
                'statistikPendidikan'
            ));

        } catch (\Exception $e) {
            \Log::error('Error loading tentang page: ' . $e->getMessage());
            
            // Jika error, tetap tampilkan halaman dengan data default
            $profil = null;
            $perangkat = collect();
            $layanan = collect();
            $statistikPenduduk = [
                'total' => 0,
                'pria' => 0,
                'wanita' => 0,
                'total_kk' => 0,
            ];
            $kelompokUmur = [
                'anak' => 0,
                'dewasa' => 0,
                'lansia' => 0,
            ];
            $statistikPekerjaan = collect();
            $statistikPendidikan = collect();

            return view('public.tentang', compact(
                'profil',
                'perangkat',
                'layanan',
                'statistikPenduduk',
                'kelompokUmur',
                'statistikPekerjaan',
                'statistikPendidikan'
            ));
        }
    }

    /**
     * Halaman Layanan Public
     */
    public function layanan(Request $request)
    {
        $query = Layanan::active()->ordered();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('persyaratan', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $layanan = $query->paginate(12);

        // Get available categories
        $categories = Layanan::active()
            ->selectRaw('kategori, COUNT(*) as count')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        return view('public.layanan', compact('layanan', 'categories'));
    }

    /**
     * Detail Layanan
     */
    public function layananDetail($slug)
    {
        try {
            $layanan = Layanan::active()
                ->where('slug', $slug)
                ->firstOrFail();

            // Get related layanan (same category, exclude current)
            $relatedLayanan = Layanan::active()
                ->where('kategori', $layanan->kategori)
                ->where('id', '!=', $layanan->id)
                ->ordered()
                ->take(4)
                ->get();

            return view('public.detail-layanan', compact('layanan', 'relatedLayanan'));

        } catch (\Exception $e) {
            return redirect()->route('layanan')
                ->with('error', 'Layanan yang Anda cari tidak ditemukan.');
        }
    }
}