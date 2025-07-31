<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PermohonanSurat extends Model
{
    use HasFactory;

    protected $table = 'permohonan_surat';

    protected $fillable = [
        'nomor_permohonan', 'nama_pemohon', 'nik', 'alamat', 'rt', 'rw',
        'telepon', 'email', 'jenis_surat', 'keperluan', 'dokumen_pendukung',
        'tanggal_permohonan', 'tanggal_estimasi_selesai', 'tanggal_selesai',
        'status', 'keterangan', 'alasan_penolakan', 'biaya', 'admin_processor',
        'nomor_surat', 'file_surat',
    ];

    protected $casts = [
        'tanggal_permohonan' => 'date',
        'tanggal_estimasi_selesai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function getFileSuratAttribute($value)
    {
        return $value ? asset('storage/surat/output/' . $value) : null;
    }

    public function getDokumenPendukungArrayAttribute()
    {
        return $this->dokumen_pendukung ? explode(',', $this->dokumen_pendukung) : [];
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByJenisSurat($query, $jenis)
    {
        return $query->where('jenis_surat', $jenis);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_permohonan', 'desc');
    }

    // Relationships
    public function penduduk()
    {
        return $this->belongsTo(DataPenduduk::class, 'nik', 'nik');
    }

    public function processor()
    {
        return $this->belongsTo(Admin::class, 'admin_processor');
    }
}
