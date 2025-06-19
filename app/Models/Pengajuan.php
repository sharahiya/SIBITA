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
        'alasan_ditolak',
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


    public function pengajuanSeminar()
    {
        return $this->hasMany(PengajuanSeminar::class, 'id_seminar', 'id_seminar');
    }

    public function getPengajuanDosen1()
    {
        return $this->pengajuanSeminar()
            ->where('dosen_ke', 1)
            ->first();
    }

    public function getPengajuanDosen2()
    {
        return $this->pengajuanSeminar()
            ->where('dosen_ke', 2)
            ->first();
    }

    public function getPengajuanByDosen($dosenId)
    {
        return $this->pengajuanSeminar()
            ->where('id_dosen', $dosenId)
            ->first();
    }

    public function getStatusDosen1()
    {
        return $this->getPengajuanDosen1()?->status ?? 'pending';
    }

    public function getStatusDosen2()
    {
        return $this->getPengajuanDosen2()?->status ?? 'pending';
    }

    public function getStatusByDosen($dosenId)
    {
        return $this->getPengajuanByDosen($dosenId)?->status ?? 'pending';
    }
}
