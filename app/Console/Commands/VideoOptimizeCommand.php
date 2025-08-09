<?php

// File: app/Console/Commands/VideoOptimizeCommand.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VideoService;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\Log;

class VideoOptimizeCommand extends Command
{
    protected $signature = 'video:optimize {--force : Force optimization even if already optimized}';
    protected $description = 'Optimize video files for better performance';

    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        parent::__construct();
        $this->videoService = $videoService;
    }

    public function handle()
    {
        $this->info('Starting video optimization...');

        $profil = ProfilNagari::first();

        if (!$profil || !$profil->hasVideoFile()) {
            $this->warn('No video found to optimize.');
            return 0;
        }

        $videoPath = public_path('uploads/videos/' . $profil->getVideoFilename());
        $optimizedPath = str_replace('.', '_optimized.', $videoPath);

        // Check if already optimized
        if (file_exists($optimizedPath) && !$this->option('force')) {
            $this->warn('Video already optimized. Use --force to re-optimize.');
            return 0;
        }

        $this->info("Optimizing video: {$profil->getVideoFilename()}");

        $bar = $this->output->createProgressBar(100);
        $bar->start();

        try {
            // Simulate progress
            for ($i = 0; $i <= 100; $i += 10) {
                $bar->advance(10);
                sleep(1);
            }

            $result = $this->videoService->optimizeVideo($videoPath);

            $bar->finish();
            $this->newLine();

            if ($result) {
                $originalSize = filesize($videoPath);
                $optimizedSize = filesize($result);
                $savings = round((($originalSize - $optimizedSize) / $originalSize) * 100, 2);

                $this->info("✅ Video optimized successfully!");
                $this->info("Original size: " . $this->formatBytes($originalSize));
                $this->info("Optimized size: " . $this->formatBytes($optimizedSize));
                $this->info("Space saved: {$savings}%");

                Log::info('Video optimization completed', [
                    'original_size' => $originalSize,
                    'optimized_size' => $optimizedSize,
                    'savings_percent' => $savings
                ]);
            } else {
                $this->error("❌ Video optimization failed!");
            }

        } catch (\Exception $e) {
            $bar->finish();
            $this->newLine();
            $this->error("❌ Error during optimization: " . $e->getMessage());
            Log::error('Video optimization error: ' . $e->getMessage());
            return 1;
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
