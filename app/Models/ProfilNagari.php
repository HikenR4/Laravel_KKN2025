<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'koordinat_lat' => 'decimal:7',
        'koordinat_lng' => 'decimal:7',
        'jumlah_rt' => 'integer',
        'jumlah_rw' => 'integer',
    ];

    public function getLogoAttribute($value)
    {
        return $value ? asset('storage/nagari/logo/' . $value) : asset('images/default-logo.png');
    }

    public function getBannerAttribute($value)
    {
        return $value ? asset('storage/nagari/banner/' . $value) : asset('images/default-banner.jpg');
    }

    public function getKoordinatAttribute()
    {
        return [
            'lat' => $this->koordinat_lat,
            'lng' => $this->koordinat_lng,
        ];
    }
}
