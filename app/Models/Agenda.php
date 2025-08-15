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
        if (!$value) {
            return asset('images/default-event.jpg');
        }
        
        // If it's already a full URL (starts with http), return as is
        if (strpos($value, 'http') === 0) {
            return $value;
        }
        
        // If it's just a filename, construct the full path
        if (strpos($value, 'uploads/agenda/') === false) {
            return asset('uploads/agenda/' . $value);
        }
        
        // If it already contains the path, return as asset
        return asset($value);
    }

    // Simplified time accessors - safe approach
    public function getWaktuMulaiAttribute($value)
    {
        if (!$value) return null;
        
        try {
            // If value contains colons, try to extract H:i part
            if (strpos($value, ':') !== false) {
                $parts = explode(':', $value);
                if (count($parts) >= 2) {
                    return sprintf('%02d:%02d', $parts[0], $parts[1]);
                }
            }
            
            // Try parsing with Carbon
            return Carbon::parse($value)->format('H:i');
        } catch (\Exception $e) {
            // If all fails, return original or null
            return $value ?: null;
        }
    }

    public function getWaktuSelesaiAttribute($value)
    {
        if (!$value) return null;
        
        try {
            // If value contains colons, try to extract H:i part
            if (strpos($value, ':') !== false) {
                $parts = explode(':', $value);
                if (count($parts) >= 2) {
                    return sprintf('%02d:%02d', $parts[0], $parts[1]);
                }
            }
            
            // Try parsing with Carbon
            return Carbon::parse($value)->format('H:i');
        } catch (\Exception $e) {
            // If all fails, return original or null
            return $value ?: null;
        }
    }

    // Simplified time mutators - safe approach
    public function setWaktuMulaiAttribute($value)
    {
        if (!$value || trim($value) === '') {
            $this->attributes['waktu_mulai'] = null;
            return;
        }
        
        try {
            // If it already has seconds, keep it
            if (substr_count($value, ':') == 2) {
                $this->attributes['waktu_mulai'] = $value;
                return;
            }
            
            // If it's H:i format, add seconds
            if (substr_count($value, ':') == 1) {
                $this->attributes['waktu_mulai'] = $value . ':00';
                return;
            }
            
            // Try to parse with Carbon
            $this->attributes['waktu_mulai'] = Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            // If parsing fails, try to add seconds to H:i format
            if (strlen($value) == 5 && strpos($value, ':') == 2) {
                $this->attributes['waktu_mulai'] = $value . ':00';
            } else {
                $this->attributes['waktu_mulai'] = null;
            }
        }
    }

    public function setWaktuSelesaiAttribute($value)
    {
        if (!$value || trim($value) === '') {
            $this->attributes['waktu_selesai'] = null;
            return;
        }
        
        try {
            // If it already has seconds, keep it
            if (substr_count($value, ':') == 2) {
                $this->attributes['waktu_selesai'] = $value;
                return;
            }
            
            // If it's H:i format, add seconds
            if (substr_count($value, ':') == 1) {
                $this->attributes['waktu_selesai'] = $value . ':00';
                return;
            }
            
            // Try to parse with Carbon
            $this->attributes['waktu_selesai'] = Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            // If parsing fails, try to add seconds to H:i format
            if (strlen($value) == 5 && strpos($value, ':') == 2) {
                $this->attributes['waktu_selesai'] = $value . ':00';
            } else {
                $this->attributes['waktu_selesai'] = null;
            }
        }
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
            $waktu = $this->waktu_mulai;
            if ($this->waktu_selesai) {
                $waktu .= ' - ' . $this->waktu_selesai;
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
}