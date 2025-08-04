<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                           ->with('error', 'Silakan login untuk mengakses panel admin.');
        }

        $admin = Auth::guard('admin')->user();
        if ($admin->deleted_at) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                           ->with('error', 'Akun Anda telah dihapus.');
        }

        if ($admin->isLocked()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                           ->with('error', 'Akun Anda terkunci hingga ' . $admin->locked_until->format('Y-m-d H:i:s'));
        }

        if ($admin->status !== 'aktif') {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                           ->with('error', 'Akun Anda tidak aktif.');
        }

        return $next($request);
    }
}
