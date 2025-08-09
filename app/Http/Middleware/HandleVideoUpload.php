<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleVideoUpload
{
    public function handle(Request $request, Closure $next)
    {
        // Increase time limits for video upload
        if ($request->hasFile('video_profil')) {
            set_time_limit(600); // 10 minutes
            ini_set('memory_limit', '512M');
            ini_set('upload_max_filesize', '64M');
            ini_set('post_max_size', '64M');
        }

        return $next($request);
    }
}
