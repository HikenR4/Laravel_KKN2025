<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'admin_id', 'aktivitas', 'tabel_terkait', 'id_record',
        'data_lama', 'data_baru', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    public function scopeByTable($query, $table)
    {
        return $query->where('tabel_terkait', $table);
    }

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
