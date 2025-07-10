<?php

namespace App\Observers;

use App\Models\Notifikasi;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\Log;

class NotifikasiObserver
{
    /**
     * Handle the Notifikasi "created" event.
     */
    public function created(Notifikasi $notifikasi): void
    {
        // Kirim email otomatis setiap kali notifikasi baru dibuat
        try {
            EmailNotificationService::sendNotificationEmail($notifikasi);

            Log::info('Email notification triggered for new notification', [
                'notifikasi_id' => $notifikasi->id_notifikasi,
                'type' => $notifikasi->tipe_notifikasi,
                'role' => $notifikasi->role
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to trigger email notification', [
                'notifikasi_id' => $notifikasi->id_notifikasi,
                'error' => $e->getMessage()
            ]);
        }
    }
}
