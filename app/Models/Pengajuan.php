<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = ['id_mahasiswa', 'id_dosen_1', 'id_dosen_2', 'topik_ta', 'deskripsi_ta', 'status', 'tanggal_pengajuan'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function dosen1()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_1');
    }

    public function dosen2()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_2');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'id_pengajuan');
    }

    public function seminar()
    {
        return $this->hasOne(Seminar::class, 'id_pengajuan');
    }
}
