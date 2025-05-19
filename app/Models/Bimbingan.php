<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingans';
    protected $primaryKey = 'id_bimbingan';
    protected $fillable = ['id_pengajuan', 'tanggal_bimbingan', 'catatan_bimbingan', 'status_bimbingan'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }
}
