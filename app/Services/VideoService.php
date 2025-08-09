<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use getID3;

class VideoService
{
    protected $ffmpeg;
    protected $ffprobe;
    protected $getID3;

    public function __construct()
    {
        // Initialize FFMpeg if available
        try {
            $this->ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe',
                'timeout'          => 3600,
                'ffmpeg.threads'   => 12,
            ]);
            $this->ffprobe = FFProbe::create();
        } catch (\Exception $e) {
            Log::warning('FFMpeg not available: ' . $e->getMessage());
        }

        // Initialize getID3
        if (class_exists('getID3')) {
            $this->getID3 = new getID3;
        }
    }

    /**
     * Process uploaded video file
     */
    public function processVideo(UploadedFile $file, $options = [])
    {
        try {
            $result = [
                'success' => false,
                'message' => '',
                'data' => []
            ];

            // Validate file
            $validation = $this->validateVideo($file);
            if (!$validation['valid']) {
                $result['message'] = $validation['message'];
                return $result;
            }

            // Generate unique filename
            $filename = $this->generateVideoFilename($file);
            $videoPath = public_path('uploads/videos/' . $filename);

            // Ensure directory exists
            $videoDir = dirname($videoPath);
            if (!file_exists($videoDir)) {
                mkdir($videoDir, 0755, true);
            }

            // Move file
            $file->move($videoDir, $filename);

            // Get video metadata
            $metadata = $this->getVideoMetadata($videoPath);

            // Generate thumbnail if requested
            $thumbnail = null;
            if (isset($options['generate_thumbnail']) && $options['generate_thumbnail']) {
                $thumbnail = $this->generateThumbnail($videoPath, $filename);
            }

            // Optimize video if requested
            if (isset($options['optimize']) && $options['optimize']) {
                $optimizedPath = $this->optimizeVideo($videoPath, $options);
                if ($optimizedPath) {
                    // Replace original with optimized version
                    unlink($videoPath);
                    rename($optimizedPath, $videoPath);
                    $metadata = $this->getVideoMetadata($videoPath); // Update metadata
                }
            }

            $result = [
                'success' => true,
                'message' => 'Video berhasil diproses',
                'data' => [
                    'filename' => $filename,
                    'path' => $videoPath,
                    'url' => asset('uploads/videos/' . $filename),
                    'size' => round(filesize($videoPath) / (1024 * 1024), 2), // MB
                    'duration' => $metadata['duration'] ?? null,
                    'width' => $metadata['width'] ?? null,
                    'height' => $metadata['height'] ?? null,
                    'format' => $metadata['format'] ?? null,
                    'bitrate' => $metadata['bitrate'] ?? null,
                    'thumbnail' => $thumbnail
                ]
            ];

            Log::info('Video processed successfully', $result['data']);
            return $result;

        } catch (\Exception $e) {
            Log::error('Error processing video: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return [
                'success' => false,
                'message' => 'Gagal memproses video: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    /**
     * Validate video file
     */
    public function validateVideo(UploadedFile $file)
    {
        $allowedMimes = [
            'video/mp4',
            'video/avi',
            'video/mov',
            'video/wmv',
            'video/flv',
            'video/webm',
            'video/quicktime'
        ];

        $allowedExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];

        // Check file size (50MB default)
        $maxSize = 50 * 1024 * 1024;
        if ($file->getSize() > $maxSize) {
            return [
                'valid' => false,
                'message' => 'Ukuran video terlalu besar. Maksimal 50MB.'
            ];
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return [
                'valid' => false,
                'message' => 'Format video tidak didukung.'
            ];
        }

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            return [
                'valid' => false,
                'message' => 'Ekstensi file tidak didukung.'
            ];
        }

        // Additional validation using getID3
        if ($this->getID3) {
            try {
                $tempPath = $file->getRealPath();
                $fileInfo = $this->getID3->analyze($tempPath);

                // Check if it's actually a video
                if (!isset($fileInfo['video'])) {
                    return [
                        'valid' => false,
                        'message' => 'File bukan merupakan video yang valid.'
                    ];
                }

                // Check duration (max 10 minutes)
                if (isset($fileInfo['playtime_seconds']) && $fileInfo['playtime_seconds'] > 600) {
                    return [
                        'valid' => false,
                        'message' => 'Durasi video terlalu panjang. Maksimal 10 menit.'
                    ];
                }

            } catch (\Exception $e) {
                Log::warning('getID3 validation failed: ' . $e->getMessage());
            }
        }

        return [
            'valid' => true,
            'message' => 'Video valid'
        ];
    }

    /**
     * Get video metadata
     */
    public function getVideoMetadata($videoPath)
    {
        $metadata = [];

        try {
            // Try with getID3 first
            if ($this->getID3 && file_exists($videoPath)) {
                $fileInfo = $this->getID3->analyze($videoPath);

                if (isset($fileInfo['video'])) {
                    $video = $fileInfo['video'];
                    $metadata = [
                        'duration' => isset($fileInfo['playtime_seconds']) ? (int)$fileInfo['playtime_seconds'] : null,
                        'width' => $video['resolution_x'] ?? null,
                        'height' => $video['resolution_y'] ?? null,
                        'format' => $video['dataformat'] ?? null,
                        'bitrate' => isset($fileInfo['bitrate']) ? (int)$fileInfo['bitrate'] : null,
                        'framerate' => $video['frame_rate'] ?? null
                    ];
                }
            }

            // Try with FFProbe if available
            if ($this->ffprobe && empty($metadata)) {
                $videoInfo = $this->ffprobe
                    ->streams($videoPath)
                    ->videos()
                    ->first();

                if ($videoInfo) {
                    $metadata = [
                        'duration' => (int)$videoInfo->get('duration'),
                        'width' => $videoInfo->get('width'),
                        'height' => $videoInfo->get('height'),
                        'format' => $videoInfo->get('codec_name'),
                        'bitrate' => (int)$videoInfo->get('bit_rate'),
                        'framerate' => $videoInfo->get('r_frame_rate')
                    ];
                }
            }

        } catch (\Exception $e) {
            Log::warning('Failed to get video metadata: ' . $e->getMessage());
        }

        return $metadata;
    }

    /**
     * Generate video thumbnail
     */
    public function generateThumbnail($videoPath, $videoFilename)
    {
        if (!$this->ffmpeg) {
            return null;
        }

        try {
            $thumbnailFilename = 'thumb_' . pathinfo($videoFilename, PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = public_path('uploads/videos/thumbnails/' . $thumbnailFilename);

            // Ensure thumbnail directory exists
            $thumbDir = dirname($thumbnailPath);
            if (!file_exists($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            $video = $this->ffmpeg->open($videoPath);
            $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1));
            $frame->save($thumbnailPath);

            return [
                'filename' => $thumbnailFilename,
                'url' => asset('uploads/videos/thumbnails/' . $thumbnailFilename)
            ];

        } catch (\Exception $e) {
            Log::warning('Failed to generate thumbnail: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Optimize video file
     */
    public function optimizeVideo($videoPath, $options = [])
    {
        if (!$this->ffmpeg) {
            return null;
        }

        try {
            $optimizedPath = str_replace('.', '_optimized.', $videoPath);

            $video = $this->ffmpeg->open($videoPath);

            // Set format
            $format = new \FFMpeg\Format\Video\X264();
            $format->setKiloBitrate(1000); // 1000 kbps
            $format->setAudioCodec("aac");
            $format->setVideoCodec("libx264");

            // Add optimization parameters
            $format->setAdditionalParameters([
                '-preset', 'fast',
                '-crf', '23',
                '-movflags', '+faststart'
            ]);

            $video->save($format, $optimizedPath);

            return $optimizedPath;

        } catch (\Exception $e) {
            Log::warning('Failed to optimize video: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate unique video filename
     */
    private function generateVideoFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = time();
        $random = Str::random(10);

        return "video_profil_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Delete video and related files
     */
    public function deleteVideo($filename)
    {
        try {
            $videoPath = public_path('uploads/videos/' . $filename);

            // Delete main video file
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }

            // Delete thumbnail if exists
            $thumbnailFilename = 'thumb_' . pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = public_path('uploads/videos/thumbnails/' . $thumbnailFilename);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }

            // Delete optimized version if exists
            $optimizedPath = str_replace('.', '_optimized.', $videoPath);
            if (file_exists($optimizedPath)) {
                unlink($optimizedPath);
            }

            Log::info('Video deleted successfully', ['filename' => $filename]);
            return true;

        } catch (\Exception $e) {
            Log::error('Failed to delete video: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get video info for display
     */
    public function getVideoInfo($filename)
    {
        $videoPath = public_path('uploads/videos/' . $filename);

        if (!file_exists($videoPath)) {
            return null;
        }

        $metadata = $this->getVideoMetadata($videoPath);
        $size = round(filesize($videoPath) / (1024 * 1024), 2);

        return [
            'filename' => $filename,
            'url' => asset('uploads/videos/' . $filename),
            'size' => $size,
            'size_formatted' => $size >= 1024 ? round($size / 1024, 2) . ' GB' : $size . ' MB',
            'duration' => $metadata['duration'] ?? null,
            'duration_formatted' => $metadata['duration'] ? $this->formatDuration($metadata['duration']) : null,
            'width' => $metadata['width'] ?? null,
            'height' => $metadata['height'] ?? null,
            'resolution' => ($metadata['width'] && $metadata['height']) ? $metadata['width'] . 'x' . $metadata['height'] : null,
            'format' => $metadata['format'] ?? null,
            'bitrate' => $metadata['bitrate'] ?? null
        ];
    }

    /**
     * Format duration in MM:SS format
     */
    private function formatDuration($seconds)
    {
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }
}
