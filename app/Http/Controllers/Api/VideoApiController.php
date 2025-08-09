<?php

// File: app/Http/Controllers/Api/VideoApiController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilNagari;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class VideoApiController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Get video information
     */
    public function getVideoInfo(): JsonResponse
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            $response = [
                'success' => true,
                'data' => [
                    'has_local_video' => $profil->hasVideoFile(),
                    'has_external_video' => $profil->hasExternalVideo(),
                    'local_video' => null,
                    'external_video' => null,
                    'description' => $profil->video_deskripsi
                ]
            ];

            // Add local video info
            if ($profil->hasVideoFile()) {
                $videoInfo = $this->videoService->getVideoInfo($profil->getVideoFilename());
                $response['data']['local_video'] = $videoInfo;
            }

            // Add external video info
            if ($profil->hasExternalVideo()) {
                $response['data']['external_video'] = [
                    'url' => $profil->video_url,
                    'embed_url' => $profil->video_embed_url
                ];
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('API: Failed to get video info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve video information'
            ], 500);
        }
    }

    /**
     * Upload video via API
     */
    public function uploadVideo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|mimetypes:video/mp4,video/avi,video/mov,video/wmv,video/flv,video/webm|max:51200',
            'description' => 'nullable|string|max:500',
            'optimize' => 'boolean',
            'generate_thumbnail' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            // Process video upload
            $options = [
                'optimize' => $request->input('optimize', false),
                'generate_thumbnail' => $request->input('generate_thumbnail', true)
            ];

            $result = $this->videoService->processVideo($request->file('video'), $options);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

            // Delete old video if exists
            if ($profil->hasVideoFile()) {
                $this->videoService->deleteVideo($profil->getVideoFilename());
            }

            // Update profile
            $profil->update([
                'video_profil' => $result['data']['filename'],
                'video_durasi' => $result['data']['duration'],
                'video_size' => $result['data']['size'],
                'video_deskripsi' => $request->input('description'),
                'video_url' => null // Clear external video URL
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'data' => [
                    'filename' => $result['data']['filename'],
                    'url' => $result['data']['url'],
                    'size' => $result['data']['size'],
                    'duration' => $result['data']['duration'],
                    'thumbnail' => $result['data']['thumbnail']
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API: Video upload failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Video upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set external video URL
     */
    public function setExternalVideo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'video_url' => 'required|url',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            // Delete local video if exists
            if ($profil->hasVideoFile()) {
                $this->videoService->deleteVideo($profil->getVideoFilename());
            }

            // Update profile
            $profil->update([
                'video_url' => $request->input('video_url'),
                'video_deskripsi' => $request->input('description'),
                'video_profil' => null,
                'video_durasi' => null,
                'video_size' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'External video URL set successfully',
                'data' => [
                    'video_url' => $profil->video_url,
                    'embed_url' => $profil->video_embed_url,
                    'description' => $profil->video_deskripsi
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API: Failed to set external video: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to set external video URL'
            ], 500);
        }
    }

    /**
     * Delete video
     */
    public function deleteVideo(): JsonResponse
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            $deleted = false;
            $message = '';

            // Delete local video
            if ($profil->hasVideoFile()) {
                $this->videoService->deleteVideo($profil->getVideoFilename());
                $deleted = true;
                $message = 'Local video deleted successfully';
            }

            // Clear database fields
            $profil->update([
                'video_profil' => null,
                'video_url' => null,
                'video_deskripsi' => null,
                'video_durasi' => null,
                'video_size' => null
            ]);

            if (!$deleted && $profil->hasExternalVideo()) {
                $message = 'External video URL cleared successfully';
                $deleted = true;
            }

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'No video found to delete'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('API: Failed to delete video: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete video'
            ], 500);
        }
    }

    /**
     * Get video statistics
     */
    public function getVideoStats(): JsonResponse
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            $stats = [
                'has_video' => $profil->hasVideoFile() || $profil->hasExternalVideo(),
                'video_type' => null,
                'file_stats' => null,
                'storage_usage' => $this->getStorageUsage()
            ];

            if ($profil->hasVideoFile()) {
                $stats['video_type'] = 'local';
                $videoInfo = $this->videoService->getVideoInfo($profil->getVideoFilename());
                $stats['file_stats'] = $videoInfo;
            } elseif ($profil->hasExternalVideo()) {
                $stats['video_type'] = 'external';
                $stats['external_url'] = $profil->video_url;
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('API: Failed to get video stats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve video statistics'
            ], 500);
        }
    }

    /**
     * Optimize video
     */
    public function optimizeVideo(): JsonResponse
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil || !$profil->hasVideoFile()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No local video found to optimize'
                ], 404);
            }

            $videoPath = public_path('uploads/videos/' . $profil->getVideoFilename());
            $result = $this->videoService->optimizeVideo($videoPath);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Video optimization failed'
                ], 500);
            }

            $originalSize = filesize($videoPath);
            $optimizedSize = filesize($result);
            $savings = round((($originalSize - $optimizedSize) / $originalSize) * 100, 2);

            return response()->json([
                'success' => true,
                'message' => 'Video optimized successfully',
                'data' => [
                    'original_size' => $originalSize,
                    'optimized_size' => $optimizedSize,
                    'savings_percent' => $savings,
                    'optimized_file' => basename($result)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API: Video optimization failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Video optimization failed'
            ], 500);
        }
    }

    /**
     * Generate video thumbnail
     */
    public function generateThumbnail(): JsonResponse
    {
        try {
            $profil = ProfilNagari::first();

            if (!$profil || !$profil->hasVideoFile()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No local video found'
                ], 404);
            }

            $videoPath = public_path('uploads/videos/' . $profil->getVideoFilename());
            $thumbnail = $this->videoService->generateThumbnail($videoPath, $profil->getVideoFilename());

            if (!$thumbnail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thumbnail generation failed'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thumbnail generated successfully',
                'data' => $thumbnail
            ]);

        } catch (\Exception $e) {
            Log::error('API: Thumbnail generation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Thumbnail generation failed'
            ], 500);
        }
    }

    /**
     * Get storage usage statistics
     */
    private function getStorageUsage(): array
    {
        $videoDir = public_path('uploads/videos');
        $thumbnailDir = public_path('uploads/videos/thumbnails');

        $videoSize = 0;
        $videoCount = 0;
        $thumbnailSize = 0;
        $thumbnailCount = 0;

        // Calculate video directory size
        if (is_dir($videoDir)) {
            $files = glob($videoDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $videoSize += filesize($file);
                    $videoCount++;
                }
            }
        }

        // Calculate thumbnail directory size
        if (is_dir($thumbnailDir)) {
            $files = glob($thumbnailDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $thumbnailSize += filesize($file);
                    $thumbnailCount++;
                }
            }
        }

        return [
            'videos' => [
                'count' => $videoCount,
                'size_bytes' => $videoSize,
                'size_formatted' => $this->formatBytes($videoSize)
            ],
            'thumbnails' => [
                'count' => $thumbnailCount,
                'size_bytes' => $thumbnailSize,
                'size_formatted' => $this->formatBytes($thumbnailSize)
            ],
            'total' => [
                'size_bytes' => $videoSize + $thumbnailSize,
                'size_formatted' => $this->formatBytes($videoSize + $thumbnailSize)
            ]
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
