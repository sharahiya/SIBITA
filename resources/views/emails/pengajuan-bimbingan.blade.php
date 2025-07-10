{{-- resources/views/emails/pengajuan-bimbingan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Bimbingan Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            min-width: 140px;
            flex-shrink: 0;
        }
        .info-value {
            color: #333;
            flex-grow: 1;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }
        .urgent {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .date-info {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 15px 0;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SIBITA</div>
            <div class="subtitle">Sistem Informasi Bimbingan Tugas Akhir</div>
        </div>

        <div class="content">
            <div class="greeting">
                Yth. {{ $dosen->nama }},
            </div>

            <p>
                Anda telah menerima pengajuan bimbingan tugas akhir baru yang memerlukan persetujuan Anda.
            </p>

            <div class="urgent">
                <strong>⚠️ Perhatian:</strong> Pengajuan ini akan dibatalkan otomatis jika tidak ada respons dalam 3 hari sejak pengajuan diajukan.
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #007bff;">Detail Pengajuan</h3>

                <div class="info-row">
                    <div class="info-label">Nama Mahasiswa:</div>
                    <div class="info-value">{{ $mahasiswa->nama }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">NPM:</div>
                    <div class="info-value">{{ $mahasiswa->npm }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $mahasiswa->email }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Posisi Pembimbing:</div>
                    <div class="info-value">
                        Dosen Pembimbing {{ $pengajuan->dosen_ke }}
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Bidang Penelitian:</div>
                    <div class="info-value">{{ $pengajuan->bidang }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Judul Tugas Akhir:</div>
                    <div class="info-value"><strong>{{ $pengajuan->topik_ta }}</strong></div>
                </div>
            </div>

            <div class="info-box">
                <h4 style="margin-top: 0; color: #333;">Deskripsi Penelitian:</h4>
                <p style="margin: 0; text-align: justify; line-height: 1.8;">
                    {{ $pengajuan->deskripsi_ta }}
                </p>
            </div>

            <div class="date-info">
                <strong>📅 Tanggal Pengajuan:</strong>
                {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y, H:i') }} WIB
                <br>
                <strong>⏰ Batas Waktu Respons:</strong>
                {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->addDays(3)->format('d F Y, H:i') }} WIB
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/requestdosen') }}" class="button">
                    Lihat & Proses Pengajuan
                </a>
            </div>

            <p>
                Silakan login ke sistem SIBITA untuk melihat detail lengkap dan memberikan persetujuan atau penolakan terhadap pengajuan ini.
            </p>

            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h4 style="margin-top: 0; color: #495057;">Langkah Selanjutnya:</h4>
                <ol style="margin: 0; padding-left: 20px; color: #666;">
                    <li>Login ke sistem SIBITA</li>
                    <li>Buka menu "Request dari Mahasiswa"</li>
                    <li>Review detail pengajuan</li>
                    <li>Berikan persetujuan atau penolakan dengan alasan yang jelas</li>
                </ol>
            </div>
        </div>

        <div class="footer">
            <p>
                Email ini dikirim secara otomatis oleh sistem SIBITA.<br>
                Jika Anda memiliki pertanyaan, silakan hubungi administrator sistem.
            </p>
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} SIBITA - Sistem Informasi Bimbingan Tugas Akhir
            </p>
        </div>
    </div>
</body>
</html>
