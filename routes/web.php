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
use App\Http\Controllers\SeminarController;use App\Http\Controllers\DaftarAkunAdminController;
use App\Http\Controllers\PenetapanPengujiController;

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
    Route::get('/pengajuan/status', [Pengajuan2Controller::class, 'index'])->name('pengajuan2');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/pending', [PengajuanController::class, 'pending'])->name('pengajuan.pending');

    Route::get('/uploadberkas', [UploadBerkasController::class, 'index'])->name('upload.index')->middleware('cekPembimbing');
    Route::post('/uploadberkas', [UploadBerkasController::class, 'upload'])->name('upload.berkas')->middleware('cekPembimbing');

    Route::get('/waitingpage', [WaitingPageController::class, 'index'])->name('waitingpage');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/penjadwalanmhs', [PenjadwalanMhsController::class, 'index'])->name('penjadwalanmhs');
    Route::get('/settingsmhs', [SettingsMhsController::class, 'index'])->name('settingsmhs');

    Route::get('/detail/dosen/{id}', [DaftarDosenController::class, 'show'])->name('detail.dosen');
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

    Route::delete('/bimbingan/remove/{id}', [ProfileDosenController::class, 'destroy'])->name('dosen.removeBimbingan');

});

// === Admin ===
Route::middleware('admin')->group(function () {
    Route::get('/dashboardadmin', [DashboardAdminController::class, 'index'])->name('dashboardadmin');
    Route::get('/manajemenakunadmin', [ManajemenAkunAdminController::class, 'index'])->name('manajemenakunadmin');
    Route::get('/manajemenakun', [ManajemenAkunController::class, 'index'])->name('manajemenakun');
    Route::get('/daftarakunadmin', [DaftarAkunAdminController::class, 'index'])->name('daftarakunadmin');
    Route::get('/penjadwalanadmin', [PenjadwalanAdminController::class, 'index'])->name('penjadwalanadmin');
    Route::get('/requestadmin', [RequestAdminController::class, 'index'])->name('requestadmin');
    Route::get('/detaildospem1', [DetailDospem1Controller::class, 'index'])->name('detaildospem1');
    Route::get('/pengujiadmin', [PengujiAdminController::class, 'index'])->name('pengujiadmin');
    Route::get('/pengujiadmin/{id}', [PengujiAdminController::class, 'show'])->name('pengujiadmin.show');
    Route::get('/editmanajemenakun', [EditManajemenAkunController::class, 'index'])->name('editmanajemenakun');
    Route::get('/resetpass', [ResetPassController::class, 'index'])->name('resetpass');
    Route::get('/notifikasiadmin', [NotifikasiAdminController::class, 'index'])->name('notifikasiadmin');

    Route::post('/admin/upload-mahasiswa', [ManajemenAkunController::class, 'uploadMahasiswa'])->name('admin.upload.mahasiswa');
    Route::post('/admin/upload-dosen', [ManajemenAkunController::class, 'uploadDosen'])->name('admin.upload.dosen');
    Route::post('/penetapan-penguji/{mahasiswa}', [PengujiAdminController::class, 'store'])->name('penetapan-penguji.store');
    Route::delete('/penguji-reset/{mahasiswa}', [PengujiAdminController::class, 'reset'])->name('penguji.reset');

    Route::post('/admin/update-kuota', [DaftarAkunAdminController::class, 'updateKuota'])->name('admin.update-kuota');
    // Route::post('/admin/seminar/{mahasiswaId}/grades', [PengujiAdminController::class, 'updateSeminarGrades'])->name('seminar.grades.update');
    Route::post('/admin/upload-nilai/{mahasiswaId}', [PengujiAdminController::class, 'uploadNilai'])->name('upload.nilai');
    Route::put('/admin/upload-nilai/{mahasiswaId}', [PengujiAdminController::class, 'uploadNilai'])->name('upload.nilai');
    Route::get('/admin/dosen/{id}/detail', [DaftarAkunAdminController::class, 'getDosenDetail'])->name('admin.dosen.detail');
    Route::delete('/admin/upload-nilai/{mahasiswaId}', [PengujiAdminController::class, 'hapusNilai'])->name('hapus.nilai');

    Route::post('/penetapan-penguji/tambah-penguji3/{mahasiswa}', [PenetapanPengujiController::class, 'tambahPenguji3'])->name('penetapan-penguji.tambah-penguji3');
    Route::delete('/penetapan-penguji/{mahasiswa}/hapus-penguji3', [PenetapanPengujiController::class, 'hapusPenguji3'])->name('penetapan-penguji.hapus-penguji3');
    Route::put('/penetapan-penguji/{mahasiswa}/update-penguji3', [PenetapanPengujiController::class, 'updatePenguji3'])->name('penetapan-penguji.update-penguji3');
    Route::get('/penetapan-penguji/{mahasiswa}/available-lecturers', [PenetapanPengujiController::class, 'getAvailableLecturers'])->name('penetapan-penguji.available-lecturers');

    Route::match(['POST', 'PUT'], '/admin/upload-nilai/{mahasiswa}', [PengujiAdminController::class, 'uploadNilai'])->name('upload.nilai');
    Route::delete('/admin/upload-nilai/{mahasiswa}', [PengujiAdminController::class, 'hapusNilai'])->name('hapus.nilai');

});

// fitur pengajuan
Route::get('/dosen/bidang/{bidang}', [DaftarDosenController::class, 'getByBidang']);
Route::get('/search-dosen', [DaftarDosenController::class, 'search']);
// Route::post('/pengajuan/update-status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');

Route::post('/notifikasi/baca/{id}', [NotifikasiController::class, 'tandaiSatu'])->name('notifikasi.baca.satu');
Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'tandaiSemua'])->name('notifikasi.baca.semua');
Route::post('/notifikasi/hapus-semua', [NotifikasiController::class, 'hapusSemua'])->name('notifikasi.hapus.semua');
Route::post('/seminar/update-status', [SeminarController::class, 'updateStatus'])->name('seminar.updateStatus');

Route::get('/api/existing-data', [ManajemenAkunController::class, 'getExistingData']);
Route::post('/dosen/change-password', [DashboardDosenController::class, 'changePassword'])->name('dosen.change-password');

Route::post('/mahasiswa/change-password', [DashboardController::class, 'changePassword'])->name('mahasiswa.change-password');

Route::get('/pengajuan-diperlukan', function () {
    return view('perlupengajuan');
})->name('pengajuan.required');


Route::get('/error', function () {
    return view('error');
})->name('error');
