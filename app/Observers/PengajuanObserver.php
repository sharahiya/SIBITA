<?php

namespace App\Observers;

use App\Models\Notifikasi;
use App\Models\Pengajuan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class PengajuanObserver
{
    /**
     * Handle the Pengajuan "created" event.
     */
    public function created(Pengajuan $pengajuan): void
    {
        //
    }

    /**
     * Handle the Pengajuan "updated" event.
     */
    public function updated(Pengajuan $pengajuan): void
    {
        //
    }

    /**
     * Handle the Pengajuan "deleted" event.
     */
    public function deleted(Pengajuan $pengajuan): void
    {
        //
    }

    /**
     * Handle the Pengajuan "restored" event.
     */
    public function restored(Pengajuan $pengajuan): void
    {
        //
    }

    /**
     * Handle the Pengajuan "force deleted" event.
     */
    public function forceDeleted(Pengajuan $pengajuan): void
    {
        //
    }

    public function retrieved(Pengajuan $pengajuan): void
    {
        // This method is called when a Pengajuan model is retrieved from the database.
        // You can add any logic you want to execute when a Pengajuan is retrieved.

        $this->checkAndCancelExpiredPengajuan($pengajuan);
    }

    private function checkAndCancelExpiredPengajuan(Pengajuan $pengajuan): void
    {
        if ($pengajuan->status !== 'pending' && $pengajuan->status !== 'cancelled') {
            return;
        }

        $dayPassed = Carbon::parse($pengajuan->tanggal_pengajuan)->diffInDays(now());

        if ($dayPassed >= 3) {
            try {
                $pengajuan->status = 'cancelled';
                $pengajuan->save();

                Log::info('Pengajuan auto-cancelled due to expiration', [
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'tanggal_pengajuan' => $pengajuan->tanggal_pengajuan,
                    'days_passed' => $dayPassed
                ]);

                // Notifikasi ke dosen
                Notifikasi::create([
                    'id_user' => $pengajuan->id_dosen,
                    'role' => 'dosen',
                    'tipe_notifikasi' => 'Pembatalan Pengajuan Bimbingan',
                    'pesan' => 'Pengajuan bimbingan mahasiswa atas nama ' . $pengajuan->mahasiswa->nama .
                        ' dengan topik "' . $pengajuan->topik_ta . '" dibatalkan secara otomatis karena tidak ditindaklanjuti dalam 3 hari.',
                    'tanggal_kirim' => now(),
                    'status_baca' => 'belum'
                ]);

                Notifikasi::create([
                    'id_user' => $pengajuan->id_mahasiswa,
                    'role' => 'mahasiswa',
                    'tipe_notifikasi' => 'Pembatalan Pengajuan Bimbingan',
                    'pesan' => 'Pengajuan bimbingan Anda ke dosen pembimbing ke-' . $pengajuan->dosen_ke .
                        ' telah dibatalkan secara otomatis karena tidak ada tanggapan dalam 3 hari.',
                    'tanggal_kirim' => now(),
                    'status_baca' => 'belum'
                ]);

                Log::info('Notifikasi dan email berhasil dikirim', [
                    'pengajuan_id' => $pengajuan->id_pengajuan,
                    'dosen_id' => $pengajuan->dosen->id_dosen,
                    'dosen_email' => $pengajuan->dosen->email ?? 'No email',
                    'mahasiswa_nama' => $pengajuan->mahasiswa->nama
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to auto-cancel pengajuan', [
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
