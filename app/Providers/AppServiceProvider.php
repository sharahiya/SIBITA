<?php

namespace App\Providers;

use App\Models\Mahasiswa;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;
use App\Models\Pengajuan;
use App\Observers\NotifikasiObserver;
use App\Observers\PengajuanObserver;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            if (Auth::guard('mahasiswa')->check()) {
            $idMahasiswa = Auth::guard('mahasiswa')->user()->id_mahasiswa;
            $unreadCount = Notifikasi::where('id_user', $idMahasiswa)
                ->where('status_baca', 'belum')
                ->where('role', 'mahasiswa')
                ->count();

            $hasPembimbing = Pengajuan::where('id_mahasiswa', $idMahasiswa)->exists();

            $view->with([
                'unreadNotifCount' => $unreadCount,
                'hasPembimbing' => $hasPembimbing
            ]);
                }
                elseif (Auth::guard('dosen')->check()) {
                    $unreadCount = Notifikasi::where('id_user', Auth::guard('dosen')->user()->id_dosen)
                    ->where('role', 'dosen')
                    ->where('status_baca', 'belum')
                    ->count();

                $view->with('unreadNotifCount', $unreadCount);
            }
        });

        Pengajuan::observe(PengajuanObserver::class);


        Notifikasi::observe(NotifikasiObserver::class);
    }
}



