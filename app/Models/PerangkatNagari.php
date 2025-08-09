<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PerangkatNagari extends Model
{
    use HasFactory;

    protected $table = 'perangkat_nagari';

    protected $fillable = [
        'nama', 'jabatan', 'nip', 'foto', 'telepon', 'email', 'alamat',
        'pendidikan', 'masa_jabatan_mulai', 'masa_jabatan_selesai',
        'status', 'urutan',
    ];

    protected $casts = [
        'masa_jabatan_mulai' => 'date',
        'masa_jabatan_selesai' => 'date',
        'urutan' => 'integer',
    ];

    // Accessor untuk foto - hanya untuk tampilan di blade
    public function getFotoUrlAttribute()
    {
        if (!$this->attributes['foto']) {
            return asset('images/default-avatar.png');
        }

        $filePath = public_path('uploads/perangkat/' . $this->attributes['foto']);
        if (file_exists($filePath)) {
            return asset('uploads/perangkat/' . $this->attributes['foto']);
        }

        return asset('images/default-avatar.png');
    }

    // Method untuk mendapatkan raw filename (untuk keperluan hapus file)
    public function getFotoFilenameAttribute()
    {
        return $this->attributes['foto'] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')->orderBy('id', 'asc');
    }

    public function getIsActiveAttribute()
    {
        if (!$this->masa_jabatan_selesai) return true;
        return Carbon::now()->lte($this->masa_jabatan_selesai);
    }

    public function getMasaJabatanAttribute()
    {
        $mulai = $this->masa_jabatan_mulai ? $this->masa_jabatan_mulai->format('Y') : '-';
        $selesai = $this->masa_jabatan_selesai ? $this->masa_jabatan_selesai->format('Y') : 'Sekarang';
        return $mulai . ' - ' . $selesai;
    }

    // Method untuk mendapatkan urutan berikutnya
    public static function getNextUrutan()
    {
        $lastUrutan = self::max('urutan');
        return $lastUrutan ? $lastUrutan + 1 : 1;
    }
}
