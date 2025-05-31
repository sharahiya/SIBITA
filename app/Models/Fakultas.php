<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    public function jurusan()
{
    return $this->hasMany(Jurusan::class);
}
}
