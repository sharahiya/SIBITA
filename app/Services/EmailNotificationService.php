<?php

namespace App\Services;

use App\Mail\GeneralNotification;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    /**
     * Kirim email notifikasi berdasarkan data notifikasi
     */
    public static function sendNotificationEmail($notifikasi)
    {
        try {
            if ($notifikasi->role == 'dosen') {
                self::sendToDosenEmail($notifikasi);
            } elseif ($notifikasi->role == 'mahasiswa') {
                self::sendToMahasiswaEmail($notifikasi);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send notification email', [
                'notifikasi_id' => $notifikasi->id_notifikasi ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Kirim email ke dosen
     */
    private static function sendToDosenEmail($notifikasi)
    {
        $dosen = Dosen::find($notifikasi->id_user);

        if (!$dosen) {
            Log::warning('Dosen not found for notification', [
                'notifikasi_id' => $notifikasi->id_notifikasi,
                'user_id' => $notifikasi->id_user
            ]);
            return;
        }

        if (!$dosen->email) {
            Log::info('Dosen has no email, skipping email notification', [
                'dosen_id' => $dosen->id_dosen,
                'dosen_nama' => $dosen->nama
            ]);
            return;
        }

        Mail::to($dosen->email)->send(new GeneralNotification($notifikasi, $dosen, 'dosen'));

        Log::info('Email notification sent to dosen', [
            'dosen_id' => $dosen->id_dosen,
            'dosen_email' => $dosen->email,
            'notifikasi_type' => $notifikasi->tipe_notifikasi
        ]);
    }

    /**
     * Kirim email ke mahasiswa
     */
    private static function sendToMahasiswaEmail($notifikasi)
    {
        $mahasiswa = Mahasiswa::find($notifikasi->id_user);

        if (!$mahasiswa) {
            Log::warning('Mahasiswa not found for notification', [
                'notifikasi_id' => $notifikasi->id_notifikasi,
                'user_id' => $notifikasi->id_user
            ]);
            return;
        }

        if (!$mahasiswa->email) {
            Log::info('Mahasiswa has no email, skipping email notification', [
                'mahasiswa_id' => $mahasiswa->id_mahasiswa,
                'mahasiswa_nama' => $mahasiswa->nama
            ]);
            return;
        }

        Mail::to($mahasiswa->email)->send(new GeneralNotification($notifikasi, $mahasiswa, 'mahasiswa'));

        Log::info('Email notification sent to mahasiswa', [
            'mahasiswa_id' => $mahasiswa->id_mahasiswa,
            'mahasiswa_email' => $mahasiswa->email,
            'notifikasi_type' => $notifikasi->tipe_notifikasi
        ]);
    }

    /**
     * Kirim email untuk pengajuan bimbingan (khusus)
     */
    public static function sendPengajuanBimbinganEmail($pengajuan)
    {
        try {
            $dosen = $pengajuan->dosen;
            $mahasiswa = $pengajuan->mahasiswa;

            if (!$dosen || !$dosen->email) {
                Log::info('Dosen has no email for pengajuan', [
                    'pengajuan_id' => $pengajuan->id_pengajuan,
                    'dosen_id' => $dosen->id_dosen ?? 'null'
                ]);
                return;
            }

            // Buat notifikasi dummy untuk email
            $notifikasi = (object) [
                'tipe_notifikasi' => 'Pengajuan Bimbingan',
                'pesan' => "Pengajuan Dosen Pembimbing {$pengajuan->dosen_ke} baru dari mahasiswa {$mahasiswa->nama}. Topik: {$pengajuan->topik_ta}",
                'tanggal_kirim' => $pengajuan->tanggal_pengajuan,
                'role' => 'dosen'
            ];

            Mail::to($dosen->email)->send(new GeneralNotification($notifikasi, $dosen, 'dosen'));

            Log::info('Pengajuan bimbingan email sent', [
                'pengajuan_id' => $pengajuan->id_pengajuan,
                'dosen_email' => $dosen->email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send pengajuan bimbingan email', [
                'pengajuan_id' => $pengajuan->id_pengajuan ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }
}
