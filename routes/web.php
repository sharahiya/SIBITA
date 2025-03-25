<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DaftarDosenController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\statusController;
#status tu setelah pengajuan#
use App\Http\Controllers\DetailMhsController;
use App\Http\Controllers\ProfileDosenController;
use App\Http\Controllers\ManajemenAkunAdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UploadBerkasController;
use App\Http\Controllers\WaitingPageController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\SuksesController;
use App\Http\Controllers\DashboardDosenController;
use App\Http\Controllers\RequestDosenController;
use App\Http\Controllers\PenjadwalanDosenController;
use App\Http\Controllers\RiwayatDosenController;
use App\Http\Controllers\PenjadwalanMhsController;
use App\Http\Controllers\SettingsMhsController;
use App\Http\Controllers\NotifikasiDosenController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\ManajemenAkunController;
use App\Http\Controllers\PenjadwalanAdminController;


Route::get('/', function () {
    return view('app');
});
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login', [LoginController::class, 'showloginpage']);
Route::get('/daftardosen', [DaftarDosenController::class, 'index'])->name('daftardosen');
Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan');
Route::get('/pengaturanakun', [PengaturanakunController::class, 'index'])->name('pengaturanakun');
Route::get('/logout', [LogoutController::class, 'index'])->name('logout');
Route::get('/status', [StatusController::class, 'index'])->name('status');
#status tu setelah pengajuan#
Route::get('/detailmhs', [DetailMhsController::class, 'index'])->name('detailmhs');
Route::get('/profiledosen', [ProfileDosenController::class, 'index'])->name('profiledosen');
Route::get('/manajemenakunadmin', [ManajemenAkunAdminController::class, 'index'])->name('manajemenakunadmin');
Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');
Route::get('/uploadberkas', [UploadBerkasController::class, 'index'])->name('uploadberkas');
Route::get('/waitingpage', [WaitingPageController::class, 'index'])->name('waitingpage');
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
Route::get('/sukses', [SuksesController::class, 'index'])->name('sukses');
Route::get('/dashboarddosen', [DashboardDosenController::class, 'index'])->name('dashboarddosen');
Route::get('/requestdosen', [RequestDosenController::class, 'index'])->name('requestdosen');
Route::get('/penjadwalandosen', [PenjadwalanDosenController::class, 'index'])->name('penjadwalandosen');
Route::get('/riwayatdosen', [RiwayatDosenController::class, 'index'])->name('riwayatdosen');
Route::get('/penjadwalanmhs', [PenjadwalanMhsController::class, 'index'])->name('penjadwalanmhs');
Route::get('/settingsmhs', [SettingsMhsController::class, 'index'])->name('settingsmhs');
Route::get('/notifikasidosen', [NotifikasiDosenController::class, 'index'])->name('notifikasidosen');
Route::get('/dashboardadmin', [DashboardAdminController::class, 'index'])->name('dashboardadmin');
Route::get('/manajemenakun', [ManajemenAkunController::class, 'index'])->name('manajemenakun');
Route::get('/penjadwalanadmin', [PenjadwalanAdminController::class, 'index'])->name('penjadwalanadmin');