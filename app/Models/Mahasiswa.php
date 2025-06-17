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
    protected $fillable = [
        'nama', 'npm', 'email', 'password', 'angkatan', 'id_dosen_wali'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships
    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'id_dosen');
    }

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_mahasiswa');
    }

    public function pengajuanSeminars()
    {
        return $this->hasMany(PengajuanSeminar::class, 'id_mahasiswa');
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'id_mahasiswa');
    }

    public function bimbingan()
    {
        return $this->hasOne(Bimbingan::class, 'id_mahasiswa');
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'id_user')->where('role', 'mahasiswa');
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

    public function cekAdaDosenPembimbing()
    {
        $res = Pengajuan::where('id_mahasiswa', $this->id_mahasiswa)
            ->exists();
        return $res;
    }

    // Method untuk mengecek apakah password masih default (sama dengan NPM)
    public function isUsingDefaultPassword()
    {
        return Hash::check($this->npm, $this->password);
    }

    /**
     * Get seminar status based on highest level achieved across all supervisors
     */
    public function getSeminarStatusAttribute()
    {
        // Get all approved PengajuanSeminar for this student
        $approvedPengajuans = $this->pengajuanSeminars()
            ->where('status', 'diterima')
            ->with('seminar')
            ->get();

        // Default status
        $status = 'Bimbingan';

        // Check which seminars have been approved
        $hasApprovedSidang = false;
        $hasApprovedSemhas = false;
        $hasApprovedSempro = false;

        foreach ($approvedPengajuans as $pengajuan) {
            if ($pengajuan->seminar) {
                switch ($pengajuan->seminar->jenis) {
                    case 'sidang':
                        $hasApprovedSidang = true;
                        break;
                    case 'hasil':
                        $hasApprovedSemhas = true;
                        break;
                    case 'proposal':
                        $hasApprovedSempro = true;
                        break;
                }
            }
        }

        // Determine status based on highest level approved
        if ($hasApprovedSidang) {
            $status = 'Sidang';
        } elseif ($hasApprovedSemhas) {
            $status = 'Semhas';
        } elseif ($hasApprovedSempro) {
            $status = 'Sempro';
        }

        return $status;
    }

    /**
     * Get seminar status for a specific supervisor
     */
    public function getSeminarStatusForDosen($dosenId)
    {
        // Get approved PengajuanSeminar for this student and specific dosen
        $approvedPengajuans = $this->pengajuanSeminars()
            ->where('id_dosen', $dosenId)
            ->where('status', 'diterima')
            ->with('seminar')
            ->get();

        // Default status
        $status = 'Bimbingan';

        // Check which seminars have been approved by this dosen
        $hasApprovedSidang = false;
        $hasApprovedSemhas = false;
        $hasApprovedSempro = false;

        foreach ($approvedPengajuans as $pengajuan) {
            if ($pengajuan->seminar) {
                switch ($pengajuan->seminar->jenis) {
                    case 'sidang':
                        $hasApprovedSidang = true;
                        break;
                    case 'hasil':
                        $hasApprovedSemhas = true;
                        break;
                    case 'proposal':
                        $hasApprovedSempro = true;
                        break;
                }
            }
        }

        // Determine status based on highest level approved by this dosen
        if ($hasApprovedSidang) {
            $status = 'Sidang';
        } elseif ($hasApprovedSemhas) {
            $status = 'Semhas';
        } elseif ($hasApprovedSempro) {
            $status = 'Sempro';
        }

        return $status;
    }

    /**
     * Check if student has graduated (completed thesis defense)
     */
    public function hasGraduated()
    {
        return $this->pengajuanSeminars()
            ->whereHas('seminar', function($query) {
                $query->where('jenis', 'sidang');
            })
            ->where('status', 'diterima')
            ->exists();
    }

    /**
     * Check if student has graduated for a specific supervisor
     */
    public function hasGraduatedForDosen($dosenId)
    {
        return $this->pengajuanSeminars()
            ->where('id_dosen', $dosenId)
            ->whereHas('seminar', function($query) {
                $query->where('jenis', 'sidang');
            })
            ->where('status', 'diterima')
            ->exists();
    }
}
