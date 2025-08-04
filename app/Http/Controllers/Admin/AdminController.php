<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
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

        if ($admin->isLocked()) {
            return back()->with('error', 'Akun terkunci hingga ' . $admin->locked_until->format('Y-m-d H:i:s'))
                         ->withInput();
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin->resetLoginAttempts();
            $admin->update(['last_login' => Carbon::now()]);

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        $attempts = $admin->login_attempts + 1;
        $maxAttempts = config('auth.max_attempts', 5);
        $lockoutMinutes = config('auth.lockout_minutes', 15);

        if ($attempts >= $maxAttempts) {
            $admin->update([
                'login_attempts' => $attempts,
                'locked_until' => Carbon::now()->addMinutes($lockoutMinutes),
            ]);

            return back()->with('error', "Terlalu banyak percobaan gagal. Akun terkunci selama {$lockoutMinutes} menit.")
                         ->withInput();
        }

        $admin->update(['login_attempts' => $attempts]);

        return back()->withErrors([
            'password' => 'Password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
