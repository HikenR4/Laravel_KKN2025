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

    public function getFotoAttribute($value)
    {
        return $value ? asset('storage/perangkat/foto/' . $value) : asset('images/default-avatar.png');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
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
}