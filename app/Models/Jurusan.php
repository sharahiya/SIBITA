<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Jurusan extends Model
{
    use HasFactory;
protected $table = 'jurusans';
protected $primaryKey = 'id';
protected $fillable = ['nama_jurusan', 'id_fakultas'];

    public function fakultas()
{
    return $this->belongsTo(Fakultas::class, 'id_fakultas', 'id');
}

public function dosen()
{
    return $this->hasMany(Dosen::class);
}
}
