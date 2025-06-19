<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasis';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = ['id_user', 'role', 'pesan', 'tanggal_kirim', 'status_baca', 'tipe_notifikasi'];
    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
