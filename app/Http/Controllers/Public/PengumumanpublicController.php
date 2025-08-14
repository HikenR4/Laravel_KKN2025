<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengumumanpublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('admin')
            ->active()
            ->latest('tanggal_mulai');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%")
                  ->orWhere('konten', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        // Filter by importance
        if ($request->filled('penting')) {
            $query->penting();
        }

        // Filter by target audience
        if ($request->filled('target')) {
            $query->where('target_audience', $request->target);
        }

        $pengumuman = $query->paginate(12);

        // Featured announcements (important ones)
        $featuredPengumuman = Pengumuman::with('admin')
            ->active()
            ->penting()
            ->latest('tanggal_mulai')
            ->take(3)
            ->get();

        // Categories with counts (sesuai dengan gambar)
        $categories = [
            'umum' => 'Umum',
            'penting' => 'Penting',
            'kegiatan' => 'Kegiatan',
            'pelayanan' => 'Pelayanan',
            'lainnya' => 'Lainnya',
        ];

        $categoriesWithCounts = collect($categories)->map(function($label, $key) {
            return [
                'label' => $label,
                'count' => Pengumuman::active()->byKategori($key)->count()
            ];
        });

        // Target audiences (sesuai dengan gambar)
        $targetAudiences = [
            'semua' => 'Semua',
            'warga' => 'Warga',
            'perangkat' => 'Perangkat',
            'tokoh_masyarakat' => 'Tokoh Masyarakat',
        ];

        // Total counts for info
        $totalPengumuman = Pengumuman::active()->count();
        $totalPenting = Pengumuman::active()->penting()->count();

        return view('public.pengumuman', compact(
            'pengumuman',
            'featuredPengumuman',
            'categories',
            'categoriesWithCounts',
            'targetAudiences',
            'totalPengumuman',
            'totalPenting'
        ));
    }

    public function show($slug)
    {
        $pengumuman = Pengumuman::with('admin')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Increment views
        $pengumuman->increment('views');

        // Related announcements
        $relatedPengumuman = Pengumuman::with('admin')
            ->active()
            ->where('id', '!=', $pengumuman->id)
            ->where('kategori', $pengumuman->kategori)
            ->latest('tanggal_mulai')
            ->take(3)
            ->get();

        // Target audiences untuk tampilan
        $targetAudiences = [
            'semua' => 'Semua',
            'warga' => 'Warga',
            'perangkat' => 'Perangkat',
            'tokoh_masyarakat' => 'Tokoh Masyarakat',
        ];

        return view('public.pengumuman-detail', compact('pengumuman', 'relatedPengumuman', 'targetAudiences'));
    }

    public function byKategori($kategori)
    {
        $categories = [
            'umum' => 'Umum',
            'penting' => 'Penting',
            'kegiatan' => 'Kegiatan',
            'pelayanan' => 'Pelayanan',
            'lainnya' => 'Lainnya',
        ];

        if (!array_key_exists($kategori, $categories)) {
            abort(404);
        }

        request()->merge(['kategori' => $kategori]);

        return $this->index(request());
    }

    public function byTarget($target)
    {
        $targetAudiences = [
            'semua' => 'Semua',
            'warga' => 'Warga',
            'perangkat' => 'Perangkat',
            'tokoh_masyarakat' => 'Tokoh Masyarakat',
        ];

        if (!array_key_exists($target, $targetAudiences)) {
            abort(404);
        }

        request()->merge(['target' => $target]);

        return $this->index(request());
    }

    public function penting()
    {
        request()->merge(['penting' => '1']);

        return $this->index(request());
    }
}
