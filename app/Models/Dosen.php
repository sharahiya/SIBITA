<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory;

    protected $table = 'dosens';
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['nip', 'nama', 'bidang', 'kuota_bimbingan', 'password', 'link_wa_group', 'id_jurusan', 'id_fakultas'];

    public function mahasiswaWali()
    {
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_dosen');
    }

    public function pengajuanAktif()
    {
        return $this->pengajuan()->whereIn('status', ['pending', 'proses', 'diterima']);
    }

    public function getRemainingQuotaAttribute()
    {
        $usedQuota = $this->pengajuanAktif()->count();
        return $this->kuota_bimbingan - $usedQuota;
    }

    public function getPengajuanByMahasiswaId($idMahasiswa)
    {
        return $this->pengajuan()->where('id_mahasiswa', $idMahasiswa)->get();
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas');
    }


    // Method untuk menghitung jumlah mahasiswa bimbingan dari pengajuan dengan status disetujui
    public function jumlahMahasiswaBimbingan()
    {
        $dataAwal = $this->pengajuan()->where('status', 'diterima')->distinct()->pluck('id_mahasiswa');
        $jumlahMahasiswa = $dataAwal->count();

        foreach ($dataAwal as $idMahasiswa) {
            $seminarSidang = Seminar::where('id_mahasiswa', $idMahasiswa)
            ->where('jenis', 'sidang')
            ->where('status', 'diterima')
            ->exists();

            if ($seminarSidang) {
            $jumlahMahasiswa--;
            }
        }

        return $jumlahMahasiswa;
    }

    public function jumlahMahasiswaPerwalian()
    {
        return $this->mahasiswaWali()->count();
    }

    public function jumlahMenjadiPenguji()
    {
        return Penguji::where('id_dosen', $this->id_dosen)->count();
    }
}
