<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul', 'slug', 'konten', 'gambar', 'tanggal_mulai', 'tanggal_berakhir',
        'waktu_mulai', 'waktu_berakhir', 'penting', 'kategori', 'target_audience',
        'status', 'views', 'admin_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'penting' => 'boolean',
        'views' => 'integer',
    ];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getGambarAttribute($value)
    {
        return $value ? asset('storage/pengumuman/gambar/' . $value) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif')
                    ->where('tanggal_mulai', '<=', Carbon::today())
                    ->where(function($q) {
                        $q->whereNull('tanggal_berakhir')
                          ->orWhere('tanggal_berakhir', '>=', Carbon::today());
                    });
    }

    public function scopePenting($query)
    {
        return $query->where('penting', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function getIsActiveAttribute()
    {
        $now = Carbon::today();
        $active = $this->status === 'aktif' && $this->tanggal_mulai <= $now;
        
        if ($this->tanggal_berakhir) {
            $active = $active && $this->tanggal_berakhir >= $now;
        }
        
        return $active;
    }

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
