<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProfilNagari extends Model
{
    protected $table = 'profil_nagari';
    protected $fillable = [
        'nama_nagari', 'kode_nagari', 'sejarah', 'visi', 'misi', 'alamat', 'kode_pos',
        'telepon', 'email', 'website', 'logo', 'banner', 'koordinat_lat', 'koordinat_lng',
        'luas_wilayah', 'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat',
        'jumlah_rt', 'jumlah_rw'
    ];

    public function getLogoFilename()
    {
        return $this->logo;
    }

    public function getBannerFilename()
    {
        return $this->banner;
    }

    public function hasLogoFile()
    {
        if (!$this->logo) {
            Log::warning('Logo filename is null');
            return false;
        }
        $path = public_path('uploads/' . $this->logo);
        $exists = File::exists($path);
        if (!$exists) {
            Log::warning('Logo file not found', ['filename' => $this->logo, 'path' => $path]);
        }
        return $exists;
    }

    public function hasBannerFile()
    {
        if (!$this->banner) {
            Log::warning('Banner filename is null');
            return false;
        }
        $path = public_path('uploads/' . $this->banner);
        $exists = File::exists($path);
        if (!$exists) {
            Log::warning('Banner file not found', ['filename' => $this->banner, 'path' => $path]);
        }
        return $exists;
    }

    public function getLogoUrl()
    {
        return $this->hasLogoFile() ? asset('uploads/' . $this->logo) : asset('images/default-logo.png');
    }

    public function getBannerUrl()
    {
        return $this->hasBannerFile() ? asset('uploads/' . $this->banner) : asset('images/default-banner.jpg');
    }

    public function getLogoPath()
    {
        return $this->logo ? public_path('uploads/' . $this->logo) : null;
    }

    public function getBannerPath()
    {
        return $this->banner ? public_path('uploads/' . $this->banner) : null;
    }
}
