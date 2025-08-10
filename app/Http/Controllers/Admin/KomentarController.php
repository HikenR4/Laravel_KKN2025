<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KomentarController extends Controller
{
    /**
     * Display a listing of comments
     */
    public function index(Request $request)
    {
        try {
            $query = Komentar::with(['berita:id,judul,slug', 'parent:id,nama'])
                            ->orderBy('created_at', 'desc');

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by berita
            if ($request->filled('berita_id')) {
                $query->where('berita_id', $request->berita_id);
            }

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('komentar', 'like', "%{$search}%");
                });
            }

            // Filter by date range
            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            $komentar = $query->paginate(15);
            $beritaList = Berita::select('id', 'judul')->orderBy('judul')->get();

            // Statistics
            $stats = [
                'total' => Komentar::count(),
                'pending' => Komentar::where('status', 'pending')->count(),
                'approved' => Komentar::where('status', 'approved')->count(),
                'rejected' => Komentar::where('status', 'rejected')->count(),
                'today' => Komentar::whereDate('created_at', Carbon::today())->count(),
            ];

            return view('admin.komentar', compact('komentar', 'beritaList', 'stats'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data komentar.');
        }
    }

    /**
     * Show the specified comment
     */
    public function show($id)
    {
        try {
            $komentar = Komentar::with(['berita:id,judul,slug', 'parent:id,nama', 'replies.replies'])
                               ->findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'id' => $komentar->id,
                        'nama' => $komentar->nama,
                        'email' => $komentar->email,
                        'telepon' => $komentar->telepon,
                        'komentar' => $komentar->komentar,
                        'rating' => $komentar->rating,
                        'status' => $komentar->status,
                        'berita' => $komentar->berita ? $komentar->berita->judul : 'Berita tidak ditemukan',
                        'parent' => $komentar->parent ? $komentar->parent->nama : null,
                        'replies_count' => $komentar->replies->count(),
                        'ip_address' => $komentar->ip_address,
                        'user_agent' => $komentar->user_agent,
                        'created_at' => $komentar->created_at->format('d/m/Y H:i'),
                        'updated_at' => $komentar->updated_at->format('d/m/Y H:i'),
                    ]
                ]);
            }

            return view('admin.komentar.show', compact('komentar'));

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Komentar tidak ditemukan.'
                ], 404);
            }

            return redirect()->route('admin.komentar')->with('error', 'Komentar tidak ditemukan.');
        }
    }

    /**
     * Approve comment
     */
    public function approve($id)
    {
        try {
            $komentar = Komentar::findOrFail($id);
            $komentar->update(['status' => 'approved']);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil disetujui.',
                'status' => 'approved'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui komentar.'
            ], 500);
        }
    }

    /**
     * Reject comment
     */
    public function reject($id)
    {
        try {
            $komentar = Komentar::findOrFail($id);
            $komentar->update(['status' => 'rejected']);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditolak.',
                'status' => 'rejected'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak komentar.'
            ], 500);
        }
    }

    /**
     * Remove the specified comment
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $komentar = Komentar::findOrFail($id);

            // Delete replies first
            $komentar->replies()->delete();

            // Delete the comment
            $komentar->delete();

            DB::commit();

            return redirect()->route('admin.komentar')
                           ->with('success', 'Komentar berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('admin.komentar')
                           ->with('error', 'Terjadi kesalahan saat menghapus komentar.');
        }
    }

    /**
     * Filter comments
     */
    public function filter(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Bulk delete comments
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:komentar,id'
            ]);

            DB::beginTransaction();

            // Delete replies first
            Komentar::whereIn('parent_id', $request->ids)->delete();

            // Delete selected comments
            $deleted = Komentar::whereIn('id', $request->ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deleted} komentar."
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus komentar.'
            ], 500);
        }
    }

    /**
     * Bulk action for comments (approve/reject)
     */
    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:komentar,id',
                'action' => 'required|in:approve,reject'
            ]);

            $status = $request->action === 'approve' ? 'approved' : 'rejected';
            $updated = Komentar::whereIn('id', $request->ids)
                              ->update(['status' => $status]);

            $actionText = $request->action === 'approve' ? 'disetujui' : 'ditolak';

            return response()->json([
                'success' => true,
                'message' => "Berhasil {$actionText} {$updated} komentar."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses komentar.'
            ], 500);
        }
    }
}
