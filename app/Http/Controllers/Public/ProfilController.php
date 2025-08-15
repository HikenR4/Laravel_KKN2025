<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilNagari;
use App\Models\PerangkatNagari;
use App\Models\DataPenduduk;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function sejarah()
    {
        $profil = ProfilNagari::first();

        return view('public.sejarah', compact('profil'));
    }

    public function visiMisi()
    {
        $profil = ProfilNagari::first();

        return view('public.visi-misi', compact('profil'));
    }

    public function perangkatNagari()
    {
        $perangkat = PerangkatNagari::active()
                                  ->ordered()
                                  ->get();

        return view('public.perangkat-nagari', compact('perangkat'));
    }

    public function dataWilayah()
    {
        $profil = ProfilNagari::first();

        // Statistik penduduk
        $totalPenduduk = DataPenduduk::active()->count();
        $pendudukPria = DataPenduduk::active()->pria()->count();
        $pendudukWanita = DataPenduduk::active()->wanita()->count();

        // Data wilayah administratif
        $jumlahRT = $profil->jumlah_rt ?? 0;
        $jumlahRW = $profil->jumlah_rw ?? 0;

        // Statistik berdasarkan RT/RW
        $statistikRT = [];
        for ($i = 1; $i <= $jumlahRT; $i++) {
            $jumlah = DataPenduduk::active()->byRT($i)->count();
            if ($jumlah > 0) {
                $statistikRT[$i] = $jumlah;
            }
        }

        $statistikRW = [];
        for ($i = 1; $i <= $jumlahRW; $i++) {
            $jumlah = DataPenduduk::active()->byRW($i)->count();
            if ($jumlah > 0) {
                $statistikRW[$i] = $jumlah;
            }
        }

        // Statistik berdasarkan usia
        $statistikUsia = [
            '0-17' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 17')->count(),
            '18-59' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 59')->count(),
            '60+' => DataPenduduk::active()->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')->count(),
        ];

        return view('public.data-wilayah', compact(
            'profil',
            'totalPenduduk',
            'pendudukPria',
            'pendudukWanita',
            'jumlahRT',
            'jumlahRW',
            'statistikRT',
            'statistikRW',
            'statistikUsia'
        ));
    }
}
