<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'foto',
        'role',
        'status',
        'last_login',
        'login_attempts',
        'locked_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'locked_until' => 'datetime',
        'login_attempts' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Mutator untuk encrypt password
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    // Accessor untuk foto dengan default
    public function getFotoAttribute($value)
    {
        return $value ? asset('storage/admin/foto/' . $value) : asset('images/default-avatar.png');
    }

    // Scope untuk admin aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope berdasarkan role
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Check apakah admin sedang terkunci
    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    // Reset login attempts
    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    // Increment login attempts
    public function incrementLoginAttempts()
    {
        $attempts = $this->login_attempts + 1;
        $lockUntil = null;

        // Lock account after 5 failed attempts for 30 minutes
        if ($attempts >= 5) {
            $lockUntil = Carbon::now()->addMinutes(30);
        }

        $this->update([
            'login_attempts' => $attempts,
            'locked_until' => $lockUntil,
        ]);
    }

    // Update last login
    public function updateLastLogin()
    {
        $this->update([
            'last_login' => Carbon::now(),
        ]);
    }

    // Relasi dengan tabel lain
    public function berita()
    {
        return $this->hasMany(Berita::class, 'admin_id');
    }

    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'admin_id');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'admin_id');
    }

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'admin_processor');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'admin_id');
    }
}
