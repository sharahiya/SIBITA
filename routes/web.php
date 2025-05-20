<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DaftarDosenController;
use App\Http\Controllers\PengajuanController;
#status tu setelah pengajuan#
use App\Http\Controllers\ProfileDosenController;
use App\Http\Controllers\ManajemenAkunAdminController;
use App\Http\Controllers\UploadBerkasController;
use App\Http\Controllers\WaitingPageController;
use App\Http\Controllers\NotifikasiController;
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
use App\Http\Controllers\RequestAdminController;
use App\Http\Controllers\Pengajuan2Controller;
use App\Http\Controllers\DetailDospem1Controller;
use App\Http\Controllers\PengujiAdminController;
use App\Http\Controllers\EditManajemenAkunController;
use App\Http\Controllers\ResetPassController;
use App\Http\Controllers\NotifikasiAdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// === Umum ===
Route::get('/login', [LoginController::class, 'showloginpage'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// === Mahasiswa ===
Route::middleware('mahasiswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/daftardosen', [DaftarDosenController::class, 'index'])->name('daftardosen');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/pending', [PengajuanController::class, 'pending'])->name('pengajuan.pending');
    Route::get('/uploadberkas', [UploadBerkasController::class, 'index'])->name('uploadberkas');
    Route::get('/waitingpage', [WaitingPageController::class, 'index'])->name('waitingpage');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/penjadwalanmhs', [PenjadwalanMhsController::class, 'index'])->name('penjadwalanmhs');
    Route::get('/settingsmhs', [SettingsMhsController::class, 'index'])->name('settingsmhs');
});

// === Dosen ===
Route::middleware('dosen')->group(function () {
    Route::get('/dashboarddosen', [DashboardDosenController::class, 'index'])->name('dashboarddosen');
    Route::get('/profiledosen', [ProfileDosenController::class, 'index'])->name('profiledosen');
    Route::get('/requestdosen', [RequestDosenController::class, 'index'])->name('requestdosen');
    Route::get('/penjadwalandosen', [PenjadwalanDosenController::class, 'index'])->name('penjadwalandosen');
    Route::get('/riwayatdosen', [RiwayatDosenController::class, 'index'])->name('riwayatdosen');
    Route::get('/notifikasidosen', [NotifikasiDosenController::class, 'index'])->name('notifikasidosen');

    Route::post('/dosen/update-kuota', [ProfileDosenController::class, 'updateKuota'])->name('dosen.updateKuota');
    Route::post('/dosen/update-whatsapp', [ProfileDosenController::class, 'updateWhatsapp'])->name('dosen.updateWhatsapp');

    Route::post('/pengajuan/update-status', [RequestDosenController::class, 'updateStatus'])->name('pengajuan.updateStatus');
});

// === Admin ===
Route::middleware('admin')->group(function () {
    Route::get('/dashboardadmin', [DashboardAdminController::class, 'index'])->name('dashboardadmin');
    Route::get('/manajemenakunadmin', [ManajemenAkunAdminController::class, 'index'])->name('manajemenakunadmin');
    Route::get('/manajemenakun', [ManajemenAkunController::class, 'index'])->name('manajemenakun');
    Route::get('/penjadwalanadmin', [PenjadwalanAdminController::class, 'index'])->name('penjadwalanadmin');
    Route::get('/requestadmin', [RequestAdminController::class, 'index'])->name('requestadmin');
    Route::get('/pengajuan2', [Pengajuan2Controller::class, 'index'])->name('pengajuan2');
    Route::get('/detaildospem1', [DetailDospem1Controller::class, 'index'])->name('detaildospem1');
    Route::get('/pengujiadmin', [PengujiAdminController::class, 'index'])->name('pengujiadmin');
    Route::get('/editmanajemenakun', [EditManajemenAkunController::class, 'index'])->name('editmanajemenakun');
    Route::get('/resetpass', [ResetPassController::class, 'index'])->name('resetpass');
    Route::get('/notifikasiadmin', [NotifikasiAdminController::class, 'index'])->name('notifikasiadmin');

    Route::post('/admin/upload-mahasiswa', [ManajemenAkunController::class, 'uploadMahasiswa'])->name('admin.upload.mahasiswa');
    Route::post('/admin/upload-dosen', [ManajemenAkunController::class, 'uploadDosen'])->name('admin.upload.dosen');
});

// fitur pengajuan
Route::get('/dosen/bidang/{bidang}', [DaftarDosenController::class, 'getByBidang']);
Route::get('/search-dosen', [DaftarDosenController::class, 'search']);

Route::get('/error', function () {
    return view('error');
})->name('error');
