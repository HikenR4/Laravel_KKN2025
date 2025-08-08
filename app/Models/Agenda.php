<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'judul', 'slug', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai',
        'waktu_mulai', 'waktu_selesai', 'lokasi', 'koordinat_lat', 'koordinat_lng',
        'gambar', 'alt_gambar', 'kategori', 'status', 'peserta_target',
        'biaya', 'penanggung_jawab', 'kontak_person', 'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'koordinat_lat' => 'decimal:7',
        'koordinat_lng' => 'decimal:7',
        'peserta_target' => 'integer',
        'biaya' => 'decimal:2',
    ];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getGambarAttribute($value)
    {
        return $value ? asset('storage/agenda/gambar/' . $value) : asset('images/default-event.jpg');
    }

    public function getTanggalLengkapAttribute()
    {
        $mulai = $this->tanggal_mulai->format('d M Y');
        if ($this->tanggal_selesai && !$this->tanggal_mulai->eq($this->tanggal_selesai)) {
            return $mulai . ' - ' . $this->tanggal_selesai->format('d M Y');
        }
        return $mulai;
    }

    public function getWaktuLengkapAttribute()
    {
        $waktu = '';
        if ($this->waktu_mulai) {
            $waktu = Carbon::parse($this->waktu_mulai)->format('H:i');
            if ($this->waktu_selesai) {
                $waktu .= ' - ' . Carbon::parse($this->waktu_selesai)->format('H:i');
            }
            $waktu .= ' WIB';
        }
        return $waktu;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>=', Carbon::today());
    }

    public function scopePast($query)
    {
        return $query->where('tanggal_mulai', '<', Carbon::today());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function agenda()
    {
    return $this->hasMany(Agenda::class, 'admin_id');
    }
}