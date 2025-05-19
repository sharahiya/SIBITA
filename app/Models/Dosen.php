<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory;

    protected $table = 'dosens';
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['nip', 'nama', 'bidang', 'kuota_bimbingan', 'password', 'link_wa_group'];

    public function mahasiswaWali()
    {
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_dosen');
    }
}
