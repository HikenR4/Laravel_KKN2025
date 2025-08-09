<?php

// File: app/Console/Commands/VideoBackupCommand.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class VideoBackupCommand extends Command
{
    protected $signature = 'video:backup {--path= : Custom backup path}';
    protected $description = 'Backup video files and metadata';

    public function handle()
    {
        $this->info('Starting video backup...');

        $profil = ProfilNagari::first();

        if (!$profil || !$profil->hasVideoFile()) {
            $this->warn('No video found to backup.');
            return 0;
        }

        $backupPath = $this->option('path') ?? storage_path('backups/videos');

        // Ensure backup directory exists
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $timestamp = date('Y-m-d_H-i-s');
        $backupFile = $backupPath . "/video_backup_{$timestamp}.zip";

        $zip = new ZipArchive();
        if ($zip->open($backupFile, ZipArchive::CREATE) !== TRUE) {
            $this->error("Cannot create backup file: {$backupFile}");
            return 1;
        }

        try {
            // Add video file
            $videoPath = public_path('uploads/videos/' . $profil->getVideoFilename());
            if (file_exists($videoPath)) {
                $zip->addFile($videoPath, 'video/' . $profil->getVideoFilename());
                $this->info("✅ Added video file to backup");
            }

            // Add thumbnail if exists
            $thumbnailFilename = 'thumb_' . pathinfo($profil->getVideoFilename(), PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = public_path('uploads/videos/thumbnails/' . $thumbnailFilename);
            if (file_exists($thumbnailPath)) {
                $zip->addFile($thumbnailPath, 'thumbnails/' . $thumbnailFilename);
                $this->info("✅ Added thumbnail to backup");
            }

            // Add metadata
            $metadata = [
                'backup_date' => date('Y-m-d H:i:s'),
                'profil_data' => $profil->toArray(),
                'video_info' => [
                    'filename' => $profil->getVideoFilename(),
                    'size' => file_exists($videoPath) ? filesize($videoPath) : 0,
                    'url' => $profil->getVideoUrl(),
                    'description' => $profil->video_deskripsi,
                    'duration' => $profil->video_durasi,
                    'external_url' => $profil->video_url
                ]
            ];

            $zip->addFromString('metadata.json', json_encode($metadata, JSON_PRETTY_PRINT));
            $this->info("✅ Added metadata to backup");

            $zip->close();

            $this->info("🎉 Backup completed successfully!");
            $this->info("Backup file: {$backupFile}");
            $this->info("Backup size: " . $this->formatBytes(filesize($backupFile)));

            return 0;

        } catch (\Exception $e) {
            $zip->close();
            $this->error("❌ Backup failed: " . $e->getMessage());

            // Clean up failed backup file
            if (file_exists($backupFile)) {
                unlink($backupFile);
            }

            return 1;
        }
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
