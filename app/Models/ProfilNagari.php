<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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

    // Logo accessors
    public function getLogoAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : asset('images/default-logo.png');
    }

    public function getLogoFilename()
    {
        return $this->attributes['logo'] ?? null;
    }

    public function getLogoUrl()
    {
        $filename = $this->getLogoFilename();
        return $filename ? asset('uploads/' . $filename) : asset('images/default-logo.png');
    }

    public function hasLogoFile()
    {
        $filename = $this->getLogoFilename();
        return $filename && File::exists(public_path('uploads/' . $filename));
    }

    // Banner accessors
    public function getBannerAttribute($value)
    {
        return $value ? asset('uploads/' . $value) : asset('images/default-banner.jpg');
    }

    public function getBannerFilename()
    {
        return $this->attributes['banner'] ?? null;
    }

    public function getBannerUrl()
    {
        $filename = $this->getBannerFilename();
        return $filename ? asset('uploads/' . $filename) : asset('images/default-banner.jpg');
    }

    public function hasBannerFile()
    {
        $filename = $this->getBannerFilename();
        return $filename && File::exists(public_path('uploads/' . $filename));
    }

    // Video accessors
    public function getVideoProfilAttribute($value)
    {
        return $value ? asset('uploads/videos/' . $value) : null;
    }

    public function getVideoFilename()
    {
        return $this->attributes['video_profil'] ?? null;
    }

    public function getVideoUrl()
    {
        $filename = $this->getVideoFilename();
        return $filename ? asset('uploads/videos/' . $filename) : null;
    }

    public function hasVideoFile()
    {
        $filename = $this->getVideoFilename();
        return $filename && File::exists(public_path('uploads/videos/' . $filename));
    }

    public function getVideoDurasiFormattedAttribute()
    {
        if (!$this->video_durasi) return null;

        $minutes = floor($this->video_durasi / 60);
        $seconds = $this->video_durasi % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

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
}
