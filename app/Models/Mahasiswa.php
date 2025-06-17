<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = ['npm', 'email', 'nama', 'password', 'angkatan', 'id_dosen_wali'];

    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_mahasiswa');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_mahasiswa');
    }

    public function pembimbing()
    {
        return $this->hasOne(Pembimbing::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    // Model Mahasiswa
    public function getDosenPembimbing1Attribute()
    {
        return $this->pembimbing?->dosen1; // Mengembalikan null jika tidak ada pembimbing
    }

    public function getDosenPembimbing2Attribute()
    {
        return $this->pembimbing?->dosen2; // Mengembalikan null jika tidak ada pembimbing
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'id_mahasiswa');
    }

    public function cekAdaDosenPembimbing()
    {
        $res = Pengajuan::where('id_mahasiswa', $this->id_mahasiswa)
            ->exists();
        return $res;
    }

    public function PengajuanSeminar()
    {
        return $this->hasMany(PengajuanSeminar::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    // Method untuk mengecek apakah password masih default (sama dengan NPM)
    public function isUsingDefaultPassword()
    {
        return Hash::check($this->npm, $this->password);
    }

    public function getSeminarStatusAttribute()
    {
        // Get the latest seminar for each type
        $seminars = $this->seminars()->get();
        
        if ($seminars->isEmpty()) {
            return 'Bimbingan'; // Default status if no seminars
        }

        // Check for completed seminars (status = 'diterima' or lulus = 1)
        $completedSidang = $seminars->where('jenis', 'sidang')
            ->where(function($seminar) {
                return $seminar->status === 'diterima' || $seminar->lulus == 1;
            })->first();
            
        $completedHasil = $seminars->where('jenis', 'hasil')
            ->where(function($seminar) {
                return $seminar->status === 'diterima' || $seminar->lulus == 1;
            })->first();
            
        $completedProposal = $seminars->where('jenis', 'proposal')
            ->where(function($seminar) {
                return $seminar->status === 'diterima' || $seminar->lulus == 1;
            })->first();

        // Check for pending seminars
        $pendingSidang = $seminars->where('jenis', 'sidang')
            ->where('status', 'pending')->first();
            
        $pendingHasil = $seminars->where('jenis', 'hasil')
            ->where('status', 'pending')->first();
            
        $pendingProposal = $seminars->where('jenis', 'proposal')
            ->where('status', 'pending')->first();

        // Determine status based on priority (completed first, then pending)
        if ($completedSidang || $pendingSidang) {
            return 'Sidang';
        } elseif ($completedHasil || $pendingHasil) {
            return 'Semhas';
        } elseif ($completedProposal || $pendingProposal) {
            return 'Sempro';
        }

        return 'Bimbingan'; // Default status
    }
}
