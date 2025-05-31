<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    public function fakultas()
{
    return $this->belongsTo(Fakultas::class, 'id_fakultas');
}

public function dosen()
{
    return $this->hasMany(Dosen::class);
}
}
