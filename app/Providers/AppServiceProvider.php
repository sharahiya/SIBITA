<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;
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
                $unreadCount = Notifikasi::where('id_user', Auth::guard('mahasiswa')->user()->id_mahasiswa)
                    ->where('status_baca', 'belum')
                    ->where('role', 'mahasiswa')
                    ->count();

                    $view->with('unreadNotifCount', $unreadCount);
                }
                elseif (Auth::guard('dosen')->check()) {
                    $unreadCount = Notifikasi::where('id_user', Auth::guard('dosen')->user()->id_dosen)
                    ->where('role', 'dosen')
                    ->where('status_baca', 'belum')
                    ->count();

                $view->with('unreadNotifCount', $unreadCount);
            }
        });
    }
}
