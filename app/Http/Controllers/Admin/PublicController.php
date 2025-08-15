<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\DataPenduduk;
use App\Models\Agenda;
use App\Models\ProfilNagari;
use App\Models\StatistikKunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    /**
     * Record visit untuk tracking statistik
     */
    private function recordVisit($halaman, $isUniqueVisitor = false)
    {
        try {
            return StatistikKunjungan::recordVisit($halaman, $isUniqueVisitor);
        } catch (\Exception $e) {
            Log::error('Error recording visit: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Format views untuk display
     */
    private function formatViews($views)
    {
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        }
        return (string) $views;
    }

    /**
     * Landing page dengan data dari database
     */
    public function landing()
    {
        try {
            // Record kunjungan
            $this->recordVisit('landing');

            // Ambil profil nagari (cache selama 1 jam)
            $profilNagari = Cache::remember('profil_nagari', 3600, function () {
                return ProfilNagari::first();
            });

            // Ambil statistik kependudukan (cache selama 30 menit)
            $statistik = Cache::remember('statistik_kependudukan', 1800, function () {
                return [
                    'total_penduduk' => DataPenduduk::active()->count(),
                    'total_kk' => DataPenduduk::active()->distinct('no_kk')->count('no_kk'),
                    'total_pria' => DataPenduduk::active()->pria()->count(),
                    'total_wanita' => DataPenduduk::active()->wanita()->count(),
                ];
            });

            // Ambil views video (cache selama 5 menit)
            $videoViews = Cache::remember('video_views', 300, function () use ($profilNagari) {
                if ($profilNagari && ($profilNagari->hasVideoFile() || $profilNagari->hasExternalVideo())) {
                    // Ambil dari statistik kunjungan atau default
                    $stats = StatistikKunjungan::where('halaman', 'video-profil')->sum('jumlah_kunjungan');
                    return $stats > 0 ? $this->formatViews($stats) : '1.9K'; // Default 1.9K
                }
                return '0';
            });

            // Ambil berita terbaru (cache selama 15 menit)
            $latestBerita = Cache::remember('latest_berita', 900, function () {
                return Berita::published()
                    ->with('admin')
                    ->latest('tanggal')
                    ->take(3)
                    ->get();
            });

            // Ambil agenda mendatang (cache selama 15 menit)
            $upcomingAgenda = Cache::remember('upcoming_agenda', 900, function () {
                return Agenda::upcoming()
                    ->with('admin')
                    ->where('status', '!=', 'cancelled')
                    ->latest('tanggal_mulai')
                    ->take(3)
                    ->get();
            });

            // Ambil pengumuman aktif (cache selama 10 menit)
            $activePengumuman = Cache::remember('active_pengumuman', 600, function () {
                return Pengumuman::active()
                    ->with('admin')
                    ->latest('tanggal_mulai')
                    ->take(3)
                    ->get();
            });

            Log::info('Landing page data loaded', [
                'profil_nagari' => $profilNagari ? $profilNagari->nama_nagari : 'Not found',
                'statistik' => $statistik,
                'video_views' => $videoViews,
                'has_video_file' => $profilNagari ? $profilNagari->hasVideoFile() : false,
                'has_external_video' => $profilNagari ? $profilNagari->hasExternalVideo() : false,
            ]);

            return view('public.landing', compact(
                'profilNagari',
                'statistik',
                'videoViews',
                'latestBerita',
                'upcomingAgenda',
                'activePengumuman'
            ));

        } catch (\Exception $e) {
            Log::error('Error in landing page: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return with minimal data if error occurs
            return view('public.landing', [
                'profilNagari' => null,
                'statistik' => [
                    'total_penduduk' => 0,
                    'total_kk' => 0,
                    'total_pria' => 0,
                    'total_wanita' => 0,
                ],
                'videoViews' => '0',
                'latestBerita' => collect(),
                'upcomingAgenda' => collect(),
                'activePengumuman' => collect(),
            ]);
        }
    }

    /**
     * API endpoint untuk mendapatkan profil nagari
     */
    public function getProfilNagari()
    {
        try {
            $profil = Cache::remember('api_profil_nagari', 3600, function () {
                return ProfilNagari::first();
            });

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil nagari tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'nama_nagari' => $profil->nama_nagari,
                    'sejarah' => $profil->sejarah,
                    'visi' => $profil->visi,
                    'misi' => $profil->misi,
                    'alamat' => $profil->alamat,
                    'telepon' => $profil->telepon,
                    'email' => $profil->email,
                    'logo_url' => $profil->getLogoUrl(),
                    'banner_url' => $profil->getBannerUrl(),
                    'koordinat' => $profil->koordinat,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting profil nagari: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data profil'
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan data video profil
     */
    public function getProfilVideo()
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil nagari tidak ditemukan'
                ], 404);
            }

            $videoData = [
                'has_video' => false,
                'type' => null,
                'url' => null,
                'embed_url' => null,
                'deskripsi' => $profil->video_deskripsi ?? 'Video profil nagari',
                'durasi' => $profil->video_durasi_formatted ?? '5:42',
                'size' => $profil->video_size_formatted ?? null,
            ];

            // Check for video file methods
            if ($profil->hasVideoFile()) {
                $videoData = array_merge($videoData, [
                    'has_video' => true,
                    'type' => 'local',
                    'url' => $profil->getVideoUrl(),
                ]);
            } elseif ($profil->hasExternalVideo()) {
                $videoData = array_merge($videoData, [
                    'has_video' => true,
                    'type' => 'external',
                    'url' => $profil->video_url ?? null,
                    'embed_url' => $profil->video_embed_url ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $videoData
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting video profil: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data video'
            ], 500);
        }
    }

    /**
     * API endpoint untuk increment video views
     */
    public function incrementVideoViews(Request $request)
    {
        try {
            $videoType = $request->input('video_type', 'local');

            // Record visit untuk video
            $stat = $this->recordVisit('video-profil', true);

            if (!$stat) {
                throw new \Exception('Failed to record visit');
            }

            // Format views untuk response
            $views = $stat->jumlah_kunjungan;
            $formattedViews = $this->formatViews($views);

            // Clear cache setelah increment
            Cache::forget('video_views');

            return response()->json([
                'success' => true,
                'views' => $views,
                'formatted_views' => $formattedViews,
                'type' => $videoType
            ]);

        } catch (\Exception $e) {
            Log::error('Error incrementing video views: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui views'
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan statistik publik
     */
    public function getPublicStatistics()
    {
        try {
            $stats = Cache::remember('public_statistics', 1800, function () {
                $profil = ProfilNagari::first();

                return [
                    'penduduk' => [
                        'total' => DataPenduduk::active()->count(),
                        'kk' => DataPenduduk::active()->distinct('no_kk')->count('no_kk'),
                        'pria' => DataPenduduk::active()->pria()->count(),
                        'wanita' => DataPenduduk::active()->wanita()->count(),
                    ],
                    'wilayah' => [
                        'rt' => $profil ? $profil->jumlah_rt : 0,
                        'rw' => $profil ? $profil->jumlah_rw : 0,
                        'luas' => $profil ? $profil->luas_wilayah : null,
                    ],
                    'content' => [
                        'berita' => Berita::published()->count(),
                        'agenda' => Agenda::upcoming()->count(),
                        'pengumuman' => Pengumuman::active()->count(),
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting public statistics: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil statistik'
            ], 500);
        }
    }

    /**
     * API endpoint untuk mendapatkan konten terbaru
     */
    public function getLatestContent(Request $request)
    {
        try {
            $type = $request->input('type', 'all');
            $limit = $request->input('limit', 5);

            $content = [];

            if ($type === 'all' || $type === 'berita') {
                $content['berita'] = Cache::remember("latest_berita_{$limit}", 900, function () use ($limit) {
                    return Berita::published()
                        ->with('admin')
                        ->latest('tanggal')
                        ->take($limit)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'judul' => $item->judul,
                                'slug' => $item->slug,
                                'excerpt' => $item->excerpt,
                                'gambar' => $item->gambar,
                                'tanggal' => $item->tanggal->format('d M Y'),
                                'views' => $item->views,
                                'kategori' => $item->kategori,
                                'admin' => $item->admin ? $item->admin->nama_lengkap : 'Admin',
                            ];
                        });
                });
            }

            if ($type === 'all' || $type === 'agenda') {
                $content['agenda'] = Cache::remember("upcoming_agenda_{$limit}", 900, function () use ($limit) {
                    return Agenda::upcoming()
                        ->with('admin')
                        ->where('status', '!=', 'cancelled')
                        ->latest('tanggal_mulai')
                        ->take($limit)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'judul' => $item->judul,
                                'slug' => $item->slug,
                                'deskripsi' => Str::limit($item->deskripsi, 100),
                                'tanggal_mulai' => $item->tanggal_mulai->format('d M Y'),
                                'lokasi' => $item->lokasi,
                                'kategori' => $item->kategori,
                                'status' => $item->status,
                            ];
                        });
                });
            }

            if ($type === 'all' || $type === 'pengumuman') {
                $content['pengumuman'] = Cache::remember("active_pengumuman_{$limit}", 600, function () use ($limit) {
                    return Pengumuman::active()
                        ->with('admin')
                        ->latest('tanggal_mulai')
                        ->take($limit)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'judul' => $item->judul,
                                'slug' => $item->slug,
                                'konten' => Str::limit(strip_tags($item->konten), 150),
                                'tanggal_mulai' => $item->tanggal_mulai->format('d M Y'),
                                'penting' => $item->penting,
                                'kategori' => $item->kategori,
                            ];
                        });
                });
            }

            return response()->json([
                'success' => true,
                'data' => $content
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting latest content: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil konten terbaru'
            ], 500);
        }
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
            Log::error('Error loading berita detail: ' . $e->getMessage());

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

        // Get available categories with counts
        $categories = [
            'rapat' => 'Rapat',
            'sosialisasi' => 'Sosialisasi',
            'pelatihan' => 'Pelatihan',
            'gotong-royong' => 'Gotong Royong',
            'keagamaan' => 'Keagamaan',
            'olahraga' => 'Olahraga',
            'budaya' => 'Budaya',
            'lainnya' => 'Lainnya'
        ];

        $categoryCounts = Agenda::where('status', '!=', 'cancelled')
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        // Add counts to categories
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
        $availableCategories = [
            'rapat' => 'Rapat',
            'sosialisasi' => 'Sosialisasi',
            'pelatihan' => 'Pelatihan',
            'gotong-royong' => 'Gotong Royong',
            'keagamaan' => 'Keagamaan',
            'olahraga' => 'Olahraga',
            'budaya' => 'Budaya',
            'lainnya' => 'Lainnya'
        ];

        // Validate category
        if (!array_key_exists($kategori, $availableCategories)) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $agenda = Agenda::with('admin')
            ->where('kategori', $kategori)
            ->where('status', '!=', 'cancelled')
            ->latest('tanggal_mulai')
            ->paginate(12);

        // Get categories with counts
        $categoryCounts = Agenda::where('status', '!=', 'cancelled')
            ->selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->pluck('count', 'kategori');

        $categoriesWithCounts = collect($availableCategories)->map(function($label, $key) use ($categoryCounts) {
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
        ->with('selectedKategoriLabel', $availableCategories[$kategori]);
    }

    /**
     * API untuk search suggestions
     */
    public function getSearchSuggestions(Request $request)
    {
        try {
            $query = $request->get('q', '');
            if (strlen($query) < 2) {
                return response()->json(['suggestions' => []]);
            }

            $suggestions = [];

            // Search in berita
            $beritaSuggestions = Berita::published()
                ->where('judul', 'like', '%' . $query . '%')
                ->select('judul', 'slug')
                ->take(5)
                ->get()
                ->map(function($item) {
                    return [
                        'title' => $item->judul,
                        'type' => 'berita',
                        'url' => route('berita.detail', $item->slug)
                    ];
                });

            // Search in agenda
            $agendaSuggestions = Agenda::where('judul', 'like', '%' . $query . '%')
                ->where('status', '!=', 'cancelled')
                ->select('judul', 'slug')
                ->take(3)
                ->get()
                ->map(function($item) {
                    return [
                        'title' => $item->judul,
                        'type' => 'agenda',
                        'url' => route('agenda.detail', $item->slug)
                    ];
                });

            $suggestions = $beritaSuggestions->concat($agendaSuggestions);

            return response()->json(['suggestions' => $suggestions->take(8)]);

        } catch (\Exception $e) {
            Log::error('Error getting search suggestions: ' . $e->getMessage());
            return response()->json(['suggestions' => []]);
        }
    }

    /**
     * API untuk popular content
     */
    public function getPopularContent(Request $request)
    {
        try {
            $type = $request->get('type', 'berita');
            $limit = $request->get('limit', 5);

            if ($type === 'berita') {
                $content = Berita::published()
                    ->orderBy('views', 'desc')
                    ->take($limit)
                    ->get()
                    ->map(function($item) {
                        return [
                            'title' => $item->judul,
                            'slug' => $item->slug,
                            'views' => $item->views,
                            'date' => $item->tanggal->format('d M Y')
                        ];
                    });
            } else {
                $content = collect();
            }

            return response()->json([
                'success' => true,
                'data' => $content
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting popular content: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil konten populer'
            ], 500);
        }
    }
}
