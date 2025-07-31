<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataPenduduk extends Model
{
    use HasFactory;

    protected $table = 'data_penduduk';

    protected $fillable = [
        'nik', 'no_kk', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'rt', 'rw', 'agama', 'status_perkawinan',
        'pekerjaan', 'pendidikan', 'golongan_darah', 'kewarganegaraan',
        'status_hubungan_keluarga', 'nama_ayah', 'nama_ibu', 'telepon',
        'email', 'status', 'tanggal_pindah', 'tanggal_meninggal', 'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pindah' => 'date',
        'tanggal_meninggal' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePria($query)
    {
        return $query->where('jenis_kelamin', 'L');
    }

    public function scopeWanita($query)
    {
        return $query->where('jenis_kelamin', 'P');
    }

    public function scopeByRT($query, $rt)
    {
        return $query->where('rt', $rt);
    }

    public function scopeByRW($query, $rw)
    {
        return $query->where('rw', $rw);
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? Carbon::parse($this->tanggal_lahir)->age : null;
    }

    public function getTempatTanggalLahirAttribute()
    {
        $tempat = $this->tempat_lahir ?: '-';
        $tanggal = $this->tanggal_lahir ? $this->tanggal_lahir->format('d-m-Y') : '-';
        return $tempat . ', ' . $tanggal;
    }

    public function getAlamatLengkapAttribute()
    {
        $alamat = $this->alamat ?: '';
        $rt = $this->rt ? ' RT ' . $this->rt : '';
        $rw = $this->rw ? ' RW ' . $this->rw : '';
        return trim($alamat . $rt . $rw);
    }

    // Relationships
    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'nik', 'nik');
    }
}                