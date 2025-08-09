<?php

namespace App\Listeners;

use App\Events\VideoProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogVideoActivity
{
    public function handle(VideoProcessed $event)
    {
        Log::info('Video processed', [
            'type' => $event->processingType,
            'filename' => $event->videoData['filename'] ?? null,
            'size' => $event->videoData['size'] ?? null,
            'duration' => $event->videoData['duration'] ?? null,
            'timestamp' => now()
        ]);
    }
}
