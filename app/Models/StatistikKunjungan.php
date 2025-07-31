<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StatistikKunjungan extends Model
{
    use HasFactory;

    protected $table = 'statistik_kunjungan';

    protected $fillable = [
        'tanggal', 'halaman', 'jumlah_kunjungan', 'unique_visitors',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_kunjungan' => 'integer',
        'unique_visitors' => 'integer',
    ];

    public function scopeToday($query)
    {
        return $query->where('tanggal', Carbon::today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', Carbon::now()->month)
                    ->whereYear('tanggal', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('tanggal', Carbon::now()->year);
    }

    public function scopeByHalaman($query, $halaman)
    {
        return $query->where('halaman', $halaman);
    }

    public static function recordVisit($halaman, $isUniqueVisitor = false)
    {
        $today = Carbon::today();
        
        $stat = static::firstOrCreate([
            'tanggal' => $today,
            'halaman' => $halaman,
        ], [
            'jumlah_kunjungan' => 0,
            'unique_visitors' => 0,
        ]);

        $stat->increment('jumlah_kunjungan');
        
        if ($isUniqueVisitor) {
            $stat->increment('unique_visitors');
        }

        return $stat;
    }
}
