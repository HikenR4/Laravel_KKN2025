<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $admin = Admin::where('username', $credentials['username'])->first();

            if (!$admin) {
                return back()->withErrors([
                    'username' => 'Username tidak ditemukan.',
                ])->withInput();
            }

            // Cek status aktif
            if ($admin->status !== 'aktif') {
                return back()->withErrors([
                    'username' => 'Akun tidak aktif. Hubungi administrator.',
                ])->withInput();
            }

            // Cek soft delete
            if (method_exists($admin, 'trashed') && $admin->trashed()) {
                return back()->withErrors([
                    'username' => 'Akun telah dihapus. Hubungi administrator.',
                ])->withInput();
            }

            if ($admin->isLocked()) {
                return back()->with('error', 'Akun terkunci hingga ' . $admin->locked_until->format('Y-m-d H:i:s'))
                             ->withInput();
            }

            if (Auth::guard('admin')->attempt($credentials)) {
                $admin->resetLoginAttempts();
                $admin->update(['last_login' => Carbon::now()]);

                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, ' . $admin->nama_lengkap);
            }

            $attempts = $admin->login_attempts + 1;
            $maxAttempts = config('auth.max_attempts', 5);
            $lockoutMinutes = config('auth.lockout_minutes', 15);

            if ($attempts >= $maxAttempts) {
                // PERBAIKAN: Pastikan addMinutes menerima integer
                $admin->update([
                    'login_attempts' => $attempts,
                    'locked_until' => Carbon::now()->addMinutes((int) $lockoutMinutes),
                ]);

                return back()->with('error', "Terlalu banyak percobaan gagal. Akun terkunci selama {$lockoutMinutes} menit.")
                             ->withInput();
            }

            $admin->update(['login_attempts' => $attempts]);
            $remaining = $maxAttempts - $attempts;

            return back()->withErrors([
                'password' => "Password salah. Sisa percobaan: {$remaining}",
            ])->withInput();

        } catch (\Exception $e) {
            Log::error('Error during admin login: ' . $e->getMessage(), [
                'username' => $request->username ?? 'unknown',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
                         ->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();

            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('success', 'Anda telah berhasil logout');

        } catch (\Exception $e) {
            Log::error('Error during admin logout: ' . $e->getMessage());

            return redirect()->route('admin.login')
                ->with('error', 'Terjadi kesalahan saat logout');
        }
    }

    public function dashboard()
    {
        try {
            // Cek jika belum login
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }

            // Ambil statistik dasar dengan error handling
            $stats = [
                'total_berita' => $this->safeCount('\App\Models\Berita'),
                'total_perangkat' => $this->safeCount('\App\Models\PerangkatNagari'),
                'total_agenda' => $this->safeCount('\App\Models\Agenda'),
                'total_pengumuman' => $this->safeCount('\App\Models\Pengumuman'),
            ];

            $recentActivities = collect(); // Default empty collection

            // Coba ambil log aktivitas jika tersedia
            try {
                if (class_exists('\App\Models\LogAktivitas')) {
                    $recentActivities = \App\Models\LogAktivitas::with('admin')
                        ->latest('created_at')
                        ->limit(10)
                        ->get();
                }
            } catch (\Exception $e) {
                Log::warning('Log activities not available: ' . $e->getMessage());
            }

            return view('admin.dashboard', compact('stats', 'recentActivities'));

        } catch (\Exception $e) {
            Log::error('Error loading admin dashboard: ' . $e->getMessage());

            return view('admin.dashboard', [
                'stats' => [
                    'total_berita' => 0,
                    'total_perangkat' => 0,
                    'total_agenda' => 0,
                    'total_pengumuman' => 0,
                ],
                'recentActivities' => collect()
            ]);
        }
    }

    /**
     * PERBAIKAN: Helper method untuk safe count
     */
    private function safeCount($modelClass)
    {
        try {
            if (class_exists($modelClass)) {
                return $modelClass::count();
            }
        } catch (\Exception $e) {
            Log::warning("Model {$modelClass} not available: " . $e->getMessage());
        }

        return 0;
    }
}
