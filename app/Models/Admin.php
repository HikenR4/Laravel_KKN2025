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

    const STATUSES = ['aktif', 'nonaktif'];

    public function setPasswordAttribute($password)
    {
        if ($password && !Hash::needsRehash($password)) {
            $this->attributes['password'] = $password;
        } else {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::STATUSES)) {
            throw new \InvalidArgumentException("Status tidak valid: {$value}");
        }
        $this->attributes['status'] = $value;
    }

    public function getFotoAttribute($value)
    {
        return $value ? asset('storage/admin/foto/' . $value) : asset('images/default-avatar.png');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function isLocked()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

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
