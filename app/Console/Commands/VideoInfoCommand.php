<?php

// File: app/Console/Commands/VideoInfoCommand.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProfilNagari;
use App\Services\VideoService;
use Illuminate\Support\Facades\File;

class VideoInfoCommand extends Command
{
    protected $signature = 'video:info';
    protected $description = 'Display video information and statistics';

    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        parent::__construct();
        $this->videoService = $videoService;
    }

    public function handle()
    {
        $this->info('📹 Video Information');
        $this->line('═══════════════════════════════════════');

        $profil = ProfilNagari::first();

        if (!$profil) {
            $this->warn('No profile found.');
            return 0;
        }

        // Profile basic info
        $this->info("Nagari: {$profil->nama_nagari}");
        $this->line('');

        // Video information
        if ($profil->hasVideoFile()) {
            $videoInfo = $this->videoService->getVideoInfo($profil->getVideoFilename());

            $this->info('🎥 Local Video File:');
            $this->line("   Filename: {$videoInfo['filename']}");
            $this->line("   Size: {$videoInfo['size_formatted']}");

            if ($videoInfo['duration_formatted']) {
                $this->line("   Duration: {$videoInfo['duration_formatted']}");
            }

            if ($videoInfo['resolution']) {
                $this->line("   Resolution: {$videoInfo['resolution']}");
            }

            if ($videoInfo['format']) {
                $this->line("   Format: {$videoInfo['format']}");
            }

            $this->line("   URL: {$videoInfo['url']}");

            // Check for optimized version
            $optimizedPath = str_replace('.', '_optimized.', public_path('uploads/videos/' . $profil->getVideoFilename()));
            if (file_exists($optimizedPath)) {
                $optimizedSize = $this->formatBytes(filesize($optimizedPath));
                $this->line("   Optimized version: Yes ({$optimizedSize})");
            } else {
                $this->line("   Optimized version: No");
            }

            // Check for thumbnail
            $thumbnailFilename = 'thumb_' . pathinfo($profil->getVideoFilename(), PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = public_path('uploads/videos/thumbnails/' . $thumbnailFilename);
            if (file_exists($thumbnailPath)) {
                $this->line("   Thumbnail: Yes");
            } else {
                $this->line("   Thumbnail: No");
            }

        } else {
            $this->warn('❌ No local video file found');
        }

        // External video URL
        if ($profil->hasExternalVideo()) {
            $this->line('');
            $this->info('🌐 External Video:');
            $this->line("   URL: {$profil->video_url}");
            $this->line("   Embed URL: {$profil->video_embed_url}");
        }

        // Video description
        if ($profil->video_deskripsi) {
            $this->line('');
            $this->info('📝 Description:');
            $this->line("   {$profil->video_deskripsi}");
        }

        // Directory statistics
        $this->line('');
        $this->info('📊 Directory Statistics:');

        $videoDir = public_path('uploads/videos');
        if (File::exists($videoDir)) {
            $files = File::files($videoDir);
            $totalSize = 0;

            foreach ($files as $file) {
                $totalSize += $file->getSize();
            }

            $this->line("   Video files: " . count($files));
            $this->line("   Total size: " . $this->formatBytes($totalSize));
        }

        $thumbnailDir = public_path('uploads/videos/thumbnails');
        if (File::exists($thumbnailDir)) {
            $thumbnails = File::files($thumbnailDir);
            $this->line("   Thumbnails: " . count($thumbnails));
        }

        return 0;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
