<?php

// File: app/Console/Commands/VideoCleanupCommand.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class VideoCleanupCommand extends Command
{
    protected $signature = 'video:cleanup {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Clean up orphaned video files';

    public function handle()
    {
        $this->info('Starting video cleanup...');

        $videoDir = public_path('uploads/videos');
        $thumbnailDir = public_path('uploads/videos/thumbnails');

        if (!File::exists($videoDir)) {
            $this->warn('Video directory does not exist.');
            return 0;
        }

        $profil = ProfilNagari::first();
        $activeVideoFilename = $profil && $profil->hasVideoFile() ? $profil->getVideoFilename() : null;

        $videoFiles = File::files($videoDir);
        $thumbnailFiles = File::exists($thumbnailDir) ? File::files($thumbnailDir) : [];

        $orphanedVideos = [];
        $orphanedThumbnails = [];
        $totalSize = 0;

        // Check video files
        foreach ($videoFiles as $file) {
            $filename = $file->getFilename();

            // Skip if this is the active video
            if ($filename === $activeVideoFilename) {
                continue;
            }

            // Check if it's an optimization file
            if (strpos($filename, '_optimized.') !== false) {
                $originalName = str_replace('_optimized.', '.', $filename);
                if ($originalName !== $activeVideoFilename) {
                    $orphanedVideos[] = $file;
                    $totalSize += $file->getSize();
                }
                continue;
            }

            // If it's not the active video, it's orphaned
            $orphanedVideos[] = $file;
            $totalSize += $file->getSize();
        }

        // Check thumbnail files
        foreach ($thumbnailFiles as $file) {
            $filename = $file->getFilename();

            // Extract original video name from thumbnail
            if (preg_match('/^thumb_(.+)\.(jpg|png)$/', $filename, $matches)) {
                $originalVideoName = $matches[1];

                // Check if corresponding video exists
                $videoExists = false;
                foreach ($videoFiles as $videoFile) {
                    $videoBasename = pathinfo($videoFile->getFilename(), PATHINFO_FILENAME);
                    if ($videoBasename === $originalVideoName) {
                        $videoExists = true;
                        break;
                    }
                }

                if (!$videoExists) {
                    $orphanedThumbnails[] = $file;
                    $totalSize += $file->getSize();
                }
            }
        }

        // Display results
        $this->info("Found " . count($orphanedVideos) . " orphaned video file(s)");
        $this->info("Found " . count($orphanedThumbnails) . " orphaned thumbnail file(s)");
        $this->info("Total size to be freed: " . $this->formatBytes($totalSize));

        if (empty($orphanedVideos) && empty($orphanedThumbnails)) {
            $this->info("✅ No orphaned files found. Nothing to clean up.");
            return 0;
        }

        // List files to be deleted
        if ($this->option('dry-run')) {
            $this->warn("DRY RUN - Files that would be deleted:");

            foreach ($orphanedVideos as $file) {
                $this->line("Video: " . $file->getFilename() . " (" . $this->formatBytes($file->getSize()) . ")");
            }

            foreach ($orphanedThumbnails as $file) {
                $this->line("Thumbnail: " . $file->getFilename() . " (" . $this->formatBytes($file->getSize()) . ")");
            }

            return 0;
        }

        // Confirm deletion
        if (!$this->confirm("Do you want to delete these orphaned files?")) {
            $this->info("Cleanup cancelled.");
            return 0;
        }

        // Delete files
        $deletedCount = 0;
        $freedSpace = 0;

        foreach ($orphanedVideos as $file) {
            try {
                $size = $file->getSize();
                File::delete($file->getPathname());
                $deletedCount++;
                $freedSpace += $size;
                $this->info("Deleted video: " . $file->getFilename());
            } catch (\Exception $e) {
                $this->error("Failed to delete " . $file->getFilename() . ": " . $e->getMessage());
            }
        }

        foreach ($orphanedThumbnails as $file) {
            try {
                $size = $file->getSize();
                File::delete($file->getPathname());
                $deletedCount++;
                $freedSpace += $size;
                $this->info("Deleted thumbnail: " . $file->getFilename());
            } catch (\Exception $e) {
                $this->error("Failed to delete " . $file->getFilename() . ": " . $e->getMessage());
            }
        }

        $this->info("🎉 Cleanup completed!");
        $this->info("Deleted {$deletedCount} file(s)");
        $this->info("Freed space: " . $this->formatBytes($freedSpace));

        Log::info('Video cleanup completed', [
            'deleted_files' => $deletedCount,
            'freed_space' => $freedSpace
        ]);

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
