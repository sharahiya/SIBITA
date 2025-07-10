<?php

namespace App\Observers;

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
        if($pengajuan->status !== 'pending'){
            return;
        }

        $dayPassed = Carbon::parse($pengajuan->tanggal_pengajuan)->diffInDays((now()));

        if($dayPassed >= 3) {
            try{
                $pengajuan->status = 'cancelled';
                $pengajuan->save();

                Log::info('Pengajuan auto-cancelled due to expiration', [
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'tanggal_pengajuan' => $pengajuan->tanggal_pengajuan,
                    'days_passed' => $dayPassed
                ]);
            }catch(\Exception $e){

                Log::error('Failed to auto-cancel pengajuan', [
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'error' => $e->getMessage()
                ]);
            }
        }

    }

}
