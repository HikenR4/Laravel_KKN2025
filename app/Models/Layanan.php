<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'kode_layanan', 'nama_layanan', 'slug', 'deskripsi', 'persyaratan',
        'prosedur', 'biaya', 'waktu_penyelesaian', 'dasar_hukum',
        'output_layanan', 'penanggung_jawab', 'kontak', 'formulir_url',
        'status', 'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function setNamaLayananAttribute($value)
    {
        $this->attributes['nama_layanan'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getPersyaratanArrayAttribute()
    {
        return $this->persyaratan ? explode("\n", $this->persyaratan) : [];
    }

    public function getProsedurArrayAttribute()
    {
        return $this->prosedur ? explode("\n", $this->prosedur) : [];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    // Relationships
    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'jenis_surat', 'nama_layanan');
    }
}
