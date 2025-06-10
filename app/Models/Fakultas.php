<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_fakultas'];


    public function jurusan()
{
    return $this->hasMany(Jurusan::class);
}
}
