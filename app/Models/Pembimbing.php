<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbings';
    protected $primaryKey = 'id_pembimbing';

    protected $fillable = ['id_mahasiswa','id_dosen_1', 'id_dosen_2'];


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function dosen1()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_1', 'id_dosen');
    }

    public function dosen2()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_2', 'id_dosen');
    }
}
