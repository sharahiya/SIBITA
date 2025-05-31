<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Seminar extends Model
    {
        use HasFactory;

        protected $table = 'seminars';
        protected $primaryKey = 'id_seminar';
        protected $fillable = ['id_mahasiswa', 'tanggal_seminar', 'status', 'lampiran', 'jenis'];
        protected $casts = [
            'tanggal_seminar' => 'date'
        ];


        public function mahasiswa()
        {
            return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
        }
    }
