<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Seminar extends Model
    {
        use HasFactory;

        protected $table = 'seminars';
        protected $primaryKey = 'id_seminar';
        protected $fillable = ['id_mahasiswa', 'tanggal_seminar', 'status', 'lampiran', 'jenis', 'nilai'];
        protected $casts = [
            'tanggal_seminar' => 'date'
        ];


        public function mahasiswa()
        {
            return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
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
