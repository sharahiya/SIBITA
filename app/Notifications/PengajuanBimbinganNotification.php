<?php

namespace App\Notifications;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanBimbinganNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $pengajuan;

    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mahasiswa = $this->pengajuan->mahasiswa;
        $daysLeft = 3 - \Carbon\Carbon::parse($this->pengajuan->tanggal_pengajuan)->diffInDays(now());

        return (new MailMessage)
            ->subject('Pengajuan Bimbingan Baru - SIBITA')
            ->greeting("Yth. {$notifiable->nama},")
            ->line('Anda telah menerima pengajuan bimbingan tugas akhir baru yang memerlukan persetujuan Anda.')
            ->line("**Nama Mahasiswa:** {$mahasiswa->nama}")
            ->line("**NPM:** {$mahasiswa->npm}")
            ->line("**Email:** {$mahasiswa->email}")
            ->line("**Posisi:** Dosen Pembimbing {$this->pengajuan->dosen_ke}")
            ->line("**Bidang:** {$this->pengajuan->bidang}")
            ->line("**Judul TA:** {$this->pengajuan->topik_ta}")
            ->line("**Deskripsi:** {$this->pengajuan->deskripsi_ta}")
            ->line("**Tanggal Pengajuan:** " . \Carbon\Carbon::parse($this->pengajuan->tanggal_pengajuan)->format('d F Y, H:i') . ' WIB')
            ->line("⚠️ **Perhatian:** Pengajuan akan dibatalkan otomatis jika tidak ada respons dalam {$daysLeft} hari lagi.")
            ->action('Lihat & Proses Pengajuan', url('/requestdosen'))
            ->line('Silakan login ke sistem SIBITA untuk memberikan persetujuan atau penolakan.')
            ->line('Terima kasih atas perhatian Anda.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_id' => $this->pengajuan->id_pengajuan,
            'mahasiswa_id' => $this->pengajuan->id_mahasiswa,
            'mahasiswa_nama' => $this->pengajuan->mahasiswa->nama,
            'mahasiswa_npm' => $this->pengajuan->mahasiswa->npm,
            'dosen_ke' => $this->pengajuan->dosen_ke,
            'topik_ta' => $this->pengajuan->topik_ta,
            'bidang' => $this->pengajuan->bidang,
            'tanggal_pengajuan' => $this->pengajuan->tanggal_pengajuan,
            'type' => 'pengajuan_bimbingan',
            'message' => "Pengajuan bimbingan baru dari {$this->pengajuan->mahasiswa->nama} sebagai Dosen Pembimbing {$this->pengajuan->dosen_ke}",
        ];
    }
}
