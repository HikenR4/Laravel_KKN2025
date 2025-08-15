<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProfilNagari extends Model
{
    use HasFactory;

    protected $table = 'profil_nagari';

    protected $fillable = [
        'nama_nagari', 'kode_nagari', 'sejarah', 'visi', 'misi', 'alamat',
        'kode_pos', 'telepon', 'email', 'website', 'logo', 'banner',
        'koordinat_lat', 'koordinat_lng', 'luas_wilayah',
        'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat',
        'jumlah_rt', 'jumlah_rw',
        // Video fields
        'video_profil', 'video_url', 'video_deskripsi', 'video_durasi', 'video_size'
    ];

    protected $casts = [
        'koordinat_lat' => 'decimal:7',
        'koordinat_lng' => 'decimal:7',
        'jumlah_rt' => 'integer',
        'jumlah_rw' => 'integer',
        'video_durasi' => 'integer',
        'video_size' => 'decimal:2',
    ];

    // FIXED: Remove automatic URL conversion from accessors
    // The accessors were causing issues with database storage

    // Logo methods - FIXED
    public function getLogoFilename()
    {
        return $this->attributes['logo'] ?? null;
    }

    public function getLogoUrl()
    {
        $filename = $this->getLogoFilename();
        if (!$filename) {
            return asset('images/default-logo.png');
        }
        return asset('uploads/' . $filename);
    }

    public function hasLogoFile()
    {
        $filename = $this->getLogoFilename();
        if (!$filename) {
            return false;
        }

        $path = public_path('uploads/' . $filename);
        $exists = File::exists($path);

        Log::info('Logo file check', [
            'filename' => $filename,
            'path' => $path,
            'exists' => $exists
        ]);

        return $exists;
    }

    // Banner methods - FIXED
    public function getBannerFilename()
    {
        return $this->attributes['banner'] ?? null;
    }

    public function getBannerUrl()
    {
        $filename = $this->getBannerFilename();
        if (!$filename) {
            return asset('images/default-banner.jpg');
        }
        return asset('uploads/' . $filename);
    }

    public function hasBannerFile()
    {
        $filename = $this->getBannerFilename();
        if (!$filename) {
            return false;
        }

        $path = public_path('uploads/' . $filename);
        $exists = File::exists($path);

        Log::info('Banner file check', [
            'filename' => $filename,
            'path' => $path,
            'exists' => $exists
        ]);

        return $exists;
    }

    // Video methods - FIXED
    public function getVideoFilename()
    {
        return $this->attributes['video_profil'] ?? null;
    }

    public function getVideoUrl()
    {
        $filename = $this->getVideoFilename();
        if (!$filename) {
            return null;
        }
        return asset('uploads/videos/' . $filename);
    }

    public function hasVideoFile()
    {
        $filename = $this->getVideoFilename();
        if (!$filename) {
            return false;
        }

        $path = public_path('uploads/videos/' . $filename);
        $exists = File::exists($path);

        Log::info('Video file check', [
            'filename' => $filename,
            'path' => $path,
            'exists' => $exists
        ]);

        return $exists;
    }

    // Video duration formatter
    public function getVideoDurasiFormattedAttribute()
    {
        if (!$this->video_durasi) return null;

        $minutes = floor($this->video_durasi / 60);
        $seconds = $this->video_durasi % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    // Video size formatter
    public function getVideoSizeFormattedAttribute()
    {
        if (!$this->video_size) return null;

        if ($this->video_size >= 1024) {
            return number_format($this->video_size / 1024, 2) . ' GB';
        }

        return number_format($this->video_size, 2) . ' MB';
    }

    // Koordinat accessor
    public function getKoordinatAttribute()
    {
        return [
            'lat' => $this->koordinat_lat,
            'lng' => $this->koordinat_lng,
        ];
    }

    // Check if using external video (YouTube, Vimeo, etc.)
    public function hasExternalVideo()
    {
        return !empty($this->video_url);
    }

    // Get embed URL for external videos
    public function getVideoEmbedUrlAttribute()
    {
        if (!$this->video_url) return null;

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return $this->video_url;
    }

    // Override save method to add debugging
    public function save(array $options = [])
    {
        Log::info('ProfilNagari save called', [
            'attributes' => $this->attributes,
            'dirty' => $this->getDirty(),
            'exists' => $this->exists
        ]);

        $result = parent::save($options);

        Log::info('ProfilNagari save result', [
            'result' => $result,
            'final_attributes' => $this->attributes
        ]);

        return $result;
    }

    // Override update method to add debugging
    public function update(array $attributes = [], array $options = [])
    {
        Log::info('ProfilNagari update called', [
            'input_attributes' => $attributes,
            'current_attributes' => $this->attributes
        ]);

        $result = parent::update($attributes, $options);

        Log::info('ProfilNagari update result', [
            'result' => $result,
            'final_attributes' => $this->fresh()->attributes ?? 'could not refresh'
        ]);

        return $result;
    }
}
