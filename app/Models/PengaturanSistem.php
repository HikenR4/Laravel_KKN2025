<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_sistem';

    protected $fillable = [
        'key_setting', 'value_setting', 'deskripsi', 'kategori',
    ];

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key_setting', $key)->first();
        return $setting ? $setting->value_setting : $default;
    }

    public static function set($key, $value, $deskripsi = null, $kategori = 'umum')
    {
        return static::updateOrCreate(
            ['key_setting' => $key],
            [
                'value_setting' => $value,
                'deskripsi' => $deskripsi,
                'kategori' => $kategori,
            ]
        );
    }
}
