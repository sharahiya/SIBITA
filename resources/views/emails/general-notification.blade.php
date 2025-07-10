{{-- resources/views/emails/general-notification.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notifikasi->tipe_notifikasi }} - SIBITA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 25px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .notification-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid {{ $notifikasi->tipe_notifikasi == 'Pengajuan Bimbingan' ? '#007bff' : ($notifikasi->tipe_notifikasi == 'Persetujuan Bimbingan' || $notifikasi->tipe_notifikasi == 'Persetujuan Seminar' ? '#28a745' : ($notifikasi->tipe_notifikasi == 'Penolakan Bimbingan' || $notifikasi->tipe_notifikasi == 'Penolakan Seminar' ? '#dc3545' : '#ffc107')) }};
        }
        .notification-type {
            color: {{ $notifikasi->tipe_notifikasi == 'Pengajuan Bimbingan' ? '#007bff' : ($notifikasi->tipe_notifikasi == 'Persetujuan Bimbingan' || $notifikasi->tipe_notifikasi == 'Persetujuan Seminar' ? '#28a745' : ($notifikasi->tipe_notifikasi == 'Penolakan Bimbingan' || $notifikasi->tipe_notifikasi == 'Penolakan Seminar' ? '#dc3545' : '#ffc107')) }};
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .message-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin: 15px 0;
            line-height: 1.8;
        }
        .date-info {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 8px 8px 0;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
            transition: all 0.3s ease;
        }
        .button:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,123,255,0.4);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #6c757d;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .header {
                margin: -20px -20px 20px -20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SIBITA</h1>
            <p>Sistem Informasi Bimbingan Tugas Akhir</p>
        </div>

        <div class="content">
            <div class="greeting">
                Yth. <strong>{{ $user->nama }}</strong>,
            </div>

            <div class="notification-box">
                <div class="notification-type">
                    @if($notifikasi->tipe_notifikasi == 'Pengajuan Bimbingan')
                        📋 {{ $notifikasi->tipe_notifikasi }}
                    @elseif($notifikasi->tipe_notifikasi == 'Persetujuan Bimbingan' || $notifikasi->tipe_notifikasi == 'Persetujuan Seminar')
                        ✅ {{ $notifikasi->tipe_notifikasi }}
                    @elseif($notifikasi->tipe_notifikasi == 'Penolakan Bimbingan' || $notifikasi->tipe_notifikasi == 'Penolakan Seminar')
                        ❌ {{ $notifikasi->tipe_notifikasi }}
                    @elseif($notifikasi->tipe_notifikasi == 'Pengajuan Dibatalkan')
                        ⚠️ {{ $notifikasi->tipe_notifikasi }}
                    @elseif($notifikasi->tipe_notifikasi == 'Bimbingan Dihapus')
                        🗑️ {{ $notifikasi->tipe_notifikasi }}
                    @elseif(str_contains($notifikasi->tipe_notifikasi, 'Seminar') || str_contains($notifikasi->tipe_notifikasi, 'Sidang'))
                        🎓 {{ $notifikasi->tipe_notifikasi }}
                    @else
                        📨 {{ $notifikasi->tipe_notifikasi }}
                    @endif
                </div>

                <div class="message-content">
                    {{ $notifikasi->pesan }}
                </div>
            </div>

            <div class="user-info">
                <strong>📧 Informasi Penerima:</strong><br>
                <strong>Nama:</strong> {{ $user->nama }}<br>
                @if($userType == 'dosen')
                    <strong>NIP:</strong> {{ $user->nip ?? '-' }}<br>
                    <strong>Bidang:</strong> {{ $user->bidang ?? '-' }}
                @else
                    <strong>NPM:</strong> {{ $user->npm ?? '-' }}<br>
                    <strong>Angkatan:</strong> {{ $user->angkatan ?? '-' }}
                @endif
            </div>

            <div class="date-info">
                <strong>📅 Tanggal Notifikasi:</strong>
                {{ \Carbon\Carbon::parse($notifikasi->tanggal_kirim)->format('d F Y, H:i') }} WIB
            </div>

            <div style="text-align: center; margin: 30px 0;">
                @if($userType == 'dosen')
                    <a href="{{ url('/requestdosen') }}" class="button">
                        🔍 Buka Dashboard Dosen
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="button">
                        🔍 Buka Dashboard Mahasiswa
                    </a>
                @endif
            </div>

            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #17a2b8;">
                <h4 style="margin-top: 0; color: #495057;">💡 Langkah Selanjutnya:</h4>
                @if($userType == 'dosen')
                    @if(str_contains($notifikasi->tipe_notifikasi, 'Pengajuan'))
                        <p style="margin: 0; color: #666;">
                            • Login ke sistem SIBITA<br>
                            • Buka menu "Request dari Mahasiswa"<br>
                            • Review dan berikan respons terhadap pengajuan<br>
                            • Berikan persetujuan atau penolakan dengan alasan yang jelas
                        </p>
                    @else
                        <p style="margin: 0; color: #666;">
                            • Login ke sistem SIBITA untuk melihat detail lengkap<br>
                            • Cek dashboard untuk informasi terbaru<br>
                            • Hubungi mahasiswa jika diperlukan
                        </p>
                    @endif
                @else
                    @if(str_contains($notifikasi->tipe_notifikasi, 'Persetujuan'))
                        <p style="margin: 0; color: #666;">
                            • Selamat! Pengajuan Anda telah disetujui<br>
                            • Login ke sistem untuk melihat status terbaru<br>
                            • Lanjutkan ke tahap berikutnya sesuai panduan
                        </p>
                    @elseif(str_contains($notifikasi->tipe_notifikasi, 'Penolakan'))
                        <p style="margin: 0; color: #666;">
                            • Review alasan penolakan dengan seksama<br>
                            • Perbaiki sesuai dengan masukan dosen<br>
                            • Ajukan kembali setelah melakukan perbaikan
                        </p>
                    @else
                        <p style="margin: 0; color: #666;">
                            • Login ke sistem SIBITA untuk melihat detail<br>
                            • Cek dashboard untuk informasi terbaru<br>
                            • Hubungi dosen pembimbing jika ada pertanyaan
                        </p>
                    @endif
                @endif
            </div>
        </div>

        <div class="footer">
            <p>
                Email ini dikirim secara otomatis oleh sistem SIBITA.<br>
                Jika Anda memiliki pertanyaan, silakan hubungi administrator sistem.
            </p>
            <p style="font-size: 12px; color: #999; margin-top: 15px;">
                © {{ date('Y') }} SIBITA - Sistem Informasi Bimbingan Tugas Akhir<br>
                <em>Universitas/Institut Teknologi</em>
            </p>
        </div>
    </div>
</body>
</html>
