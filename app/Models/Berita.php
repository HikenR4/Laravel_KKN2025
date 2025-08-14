<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'konten', 'excerpt', 'gambar', 'alt_gambar',
        'tanggal', 'views', 'status', 'featured', 'kategori', 'tags',
        'meta_description', 'admin_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'views' => 'integer',
        'featured' => 'boolean',
    ];

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // PERBAIKAN: Accessor untuk gambar di public/uploads
    public function getGambarAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // Jika sudah berupa URL lengkap, return as is
        if (str_contains($value, 'http') || str_contains($value, 'uploads/')) {
            return $value;
        }

        // Path untuk gambar yang diupload ke public/uploads
        return asset('uploads/' . $value);
    }

    // Method untuk mendapatkan path gambar asli (untuk keperluan delete file)
    public function getGambarPathAttribute()
    {
        if (!$this->attributes['gambar']) {
            return null;
        }
        return public_path('uploads/' . $this->attributes['gambar']);
    }

    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->konten), 150);
    }

    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'berita_id');
    }

    public function komentarAktif()
    {
        return $this->hasMany(Komentar::class, 'berita_id')->where('status', 'approved');
    }
}
