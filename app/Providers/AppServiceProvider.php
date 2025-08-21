<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProfilNagari;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share profil nagari data ke semua view
        View::composer('*', function ($view) {
            try {
                $profilNagari = Cache::remember('profil_nagari_global', 60, function () {
                    return ProfilNagari::first();
                });
                
                // Pastikan variable selalu ada, meski null
                $view->with('profilNagari', $profilNagari);
            } catch (\Exception $e) {
                // Jika ada error, set ke null
                $view->with('profilNagari', null);
            }
        });
    }
}
