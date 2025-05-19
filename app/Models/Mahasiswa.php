<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
