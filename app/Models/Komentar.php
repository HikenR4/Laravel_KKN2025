<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';

    protected $fillable = [
        'nama', 'email', 'telepon', 'komentar', 'berita_id', 'parent_id',
        'rating', 'ip_address', 'user_agent', 'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Relationships
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    public function parent()
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Komentar::class, 'parent_id');
    }
}
