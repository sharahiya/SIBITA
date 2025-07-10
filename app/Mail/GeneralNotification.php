<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GeneralNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $notifikasi;
    public $user;
    public $userType;

    /**
     * Create a new message instance.
     */
    public function __construct($notifikasi, $user, $userType)
    {
        $this->notifikasi = $notifikasi;
        $this->user = $user;
        $this->userType = $userType; // 'dosen' atau 'mahasiswa'
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->getEmailSubject();

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.general-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Generate email subject based on notification type
     */
    private function getEmailSubject()
    {
        $baseSubject = "SIBITA - ";

        switch($this->notifikasi->tipe_notifikasi) {
            case 'Pengajuan Bimbingan':
                return $baseSubject . "Pengajuan Bimbingan Baru";
            case 'Persetujuan Bimbingan':
                return $baseSubject . "Pengajuan Bimbingan Disetujui";
            case 'Penolakan Bimbingan':
                return $baseSubject . "Pengajuan Bimbingan Ditolak";
            case 'Pengajuan Dibatalkan':
                return $baseSubject . "Pengajuan Dibatalkan Otomatis";
            case 'Bimbingan Dihapus':
                return $baseSubject . "Bimbingan Dihapus";
            case 'Pengajuan Proposal':
                return $baseSubject . "Pengajuan Seminar Proposal";
            case 'Pengajuan Hasil':
                return $baseSubject . "Pengajuan Seminar Hasil";
            case 'Pengajuan Sidang':
                return $baseSubject . "Pengajuan Sidang";
            case 'Persetujuan Seminar':
                return $baseSubject . "Seminar Disetujui";
            case 'Penolakan Seminar':
                return $baseSubject . "Seminar Ditolak";
            default:
                return $baseSubject . "Notifikasi Baru";
        }
    }
}
