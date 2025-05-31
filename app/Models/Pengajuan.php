<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';
    protected $primaryKey = 'id_pengajuan';
    protected $fillable = [
        'id_mahasiswa',
        'id_dosen',
        'dosen_ke',
        'topik_ta',
        'deskripsi_ta',
        'bidang',
        'status',
        'tanggal_pengajuan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    public function dosenPembimbing1()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen')
            ->whereHas('pengajuan', function($query) {
                $query->where('dosen_ke', 1);
            });
    }

    public function dosenPembimbing2()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen')
            ->whereHas('pengajuan', function($query) {
                $query->where('dosen_ke', 2);
            });
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
