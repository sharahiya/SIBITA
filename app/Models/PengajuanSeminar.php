<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSeminar extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_seminar',
        'id_mahasiswa',
        'id_dosen',
        'dosen_ke',
        'status',
        'catatan'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    public function seminar()
    {
        return $this->belongsTo(Seminar::class, 'id_seminar');
    }

    public static function createForBothDospen($seminarId, $mahasiswaId, $dosen1Id, $dosen2Id)
    {
        // Create entries for both supervisors
        self::create([
            'id_seminar' => $seminarId,
            'id_mahasiswa' => $mahasiswaId,
            'id_dosen' => $dosen1Id,
            'dosen_ke' => 1,
        ]);

        self::create([
            'id_seminar' => $seminarId,
            'id_mahasiswa' => $mahasiswaId,
            'id_dosen' => $dosen2Id,
            'dosen_ke' => 2,
        ]);
    }

    public static function getPengajuanForDosen1($seminarId, $mahasiswaId)
    {
        return self::where('id_seminar', $seminarId)
            ->where('id_mahasiswa', $mahasiswaId)
            ->where('dosen_ke', 1)
            ->first();
    }

    public static function getPengajuanForDosen2($seminarId, $mahasiswaId)
    {
        return self::where('id_seminar', $seminarId)
            ->where('id_mahasiswa', $mahasiswaId)
            ->where('dosen_ke', 2)
            ->first();
    }
}
