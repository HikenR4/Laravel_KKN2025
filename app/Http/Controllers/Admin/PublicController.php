<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\DataPenduduk;
use App\Models\Agenda;
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
            ->take(4)
            ->get();
            
        return view('public.berita-detail', compact('berita', 'relatedBerita'));
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
}