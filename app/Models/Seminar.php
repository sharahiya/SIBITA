<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $table = 'seminars';
    protected $primaryKey = 'id_seminar';
    protected $fillable = ['id_pengajuan', 'tanggal_seminar', 'status', 'file_proposal', 'jenis'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }
}
