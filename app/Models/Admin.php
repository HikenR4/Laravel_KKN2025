<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admin';

    protected $fillable = [
        'username', 'password', 'nama_lengkap', 'email', 'foto',
        'status', 'last_login', 'login_attempts', 'locked_until',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'last_login' => 'datetime',
        'locked_until' => 'datetime',
        'login_attempts' => 'integer',
    ];

    /**
     * PERBAIKAN: Jangan hash password jika sudah di-hash
     */
    public function setPasswordAttribute($password)
    {
        // Jika password sudah di-hash (panjang 60 karakter), jangan hash lagi
        if (strlen($password) === 60 && preg_match('/^\$2[ayb]\$.{56}$/', $password)) {
            $this->attributes['password'] = $password;
        } else {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * PERBAIKAN: Tambahkan fallback untuk foto
     */
    public function getFotoAttribute($value)
    {
        if (!$value) {
            return asset('images/default-avatar.png');
        }

        // Cek apakah file ada
        $fotoPath = public_path('storage/admin/foto/' . $value);
        if (file_exists($fotoPath)) {
            return asset('storage/admin/foto/' . $value);
        }

        return asset('images/default-avatar.png');
    }

    /**
     * PERBAIKAN: Tambahkan accessor untuk nama file foto asli
     */
    public function getFotoFileAttribute()
    {
        return $this->attributes['foto'] ?? null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * PERBAIKAN: Gunakan Carbon yang lebih aman
     */
    public function isLocked()
    {
        if (!$this->locked_until) {
            return false;
        }

        return Carbon::now()->lt($this->locked_until);
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * PERBAIKAN: Tambahkan method untuk lock account
     */
    public function lockAccount($minutes = 15)
    {
        $this->update([
            'locked_until' => Carbon::now()->addMinutes((int) $minutes)
        ]);
    }

    /**
     * PERBAIKAN: Tambahkan method untuk unlock account
     */
    public function unlockAccount()
    {
        $this->resetLoginAttempts();
    }

    // Relationships - PERBAIKAN: Tambahkan try-catch untuk model yang mungkin belum ada
    public function berita()
    {
        try {
            return $this->hasMany(\App\Models\Berita::class, 'admin_id');
        } catch (\Exception $e) {
            return $this->hasMany(self::class, 'admin_id')->where('id', 0); // Empty relation
        }
    }

    public function agenda()
    {
        try {
            return $this->hasMany(\App\Models\Agenda::class, 'admin_id');
        } catch (\Exception $e) {
            return $this->hasMany(self::class, 'admin_id')->where('id', 0);
        }
    }

    public function pengumuman()
    {
        try {
            return $this->hasMany(\App\Models\Pengumuman::class, 'admin_id');
        } catch (\Exception $e) {
            return $this->hasMany(self::class, 'admin_id')->where('id', 0);
        }
    }

    public function permohonanSurat()
    {
        try {
            return $this->hasMany(\App\Models\PermohonanSurat::class, 'admin_processor');
        } catch (\Exception $e) {
            return $this->hasMany(self::class, 'admin_processor')->where('id', 0);
        }
    }

    public function logAktivitas()
    {
        try {
            return $this->hasMany(\App\Models\LogAktivitas::class, 'admin_id');
        } catch (\Exception $e) {
            return $this->hasMany(self::class, 'admin_id')->where('id', 0);
        }
    }
}
