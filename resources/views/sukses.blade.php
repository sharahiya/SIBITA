<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengajuan</title>
    <script src="https://cdn.tailwindcss.com"></script><script>
    tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif"],
                        inter: ["Inter", "sans-serif"],
                    },
                    colors: {
                        primary: "#1E293B",
                        secondary: "#64748B",
                        accent: "#2563EB",
                    },
                },
            },
        };
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="font-poppins bg-blue-100 flex justify-center items-center min-h-screen">
    <!-- Navbar -->
    @include('components/navbar')
    <div class="w-full max-w-3xl bg-white shadow-lg rounded-lg overflow-hidden mt-16">
        <div class="px-6 py-4 border-b bg-white text-gray-800 text-center font-semibold text-lg">
            Notifikasi
        </div>
        <div class="p-4 space-y-4">
            <!-- Notifikasi Sukses Pengajuan Diterima -->
            <div class="p-5 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                <h2 class="text-lg font-semibold">Selamat, Pengajuan Anda Berhasil!</h2>
                <p class="text-sm">Judul TA: <strong>Judul Skripsi Anda</strong></p>
                <p class="text-sm">Bidang Penelitian: <strong>Bidang Anda</strong></p>
                <p class="text-sm mt-2 font-semibold">Dosen Pembimbing:</p>
                <ul class="text-sm">
                    <li>📌 <strong>Dospem 1:</strong> Nama Dospem 1 (NIP: 12345678)</li>
                    <li>📌 <strong>Dospem 2:</strong> Nama Dospem 2 (NIP: 87654321)</li>
                </ul>
                <p class="text-sm mt-2">🔗 Link Grup WA: <a href="#" class="text-blue-600 underline">Klik di sini</a></p>
            </div>
            <!-- Notifikasi Item -->
            <div class="flex items-start space-x-3 p-3 bg-gray-50 hover:bg-gray-100 transition rounded-lg">
                <div class="w-10 h-10 bg-blue-500 text-white flex items-center justify-center rounded-full text-lg font-semibold">JD</div>
                <div>
                    <p class="text-gray-800 text-sm font-medium">Pengajuan bimbingan Anda telah diterima oleh Dosen Pembimbing.</p>
                    <span class="text-xs text-gray-500">2 jam yang lalu</span>
                </div>
            </div>
            <!-- Notifikasi Item -->
            <div class="flex items-start space-x-3 p-3 bg-gray-50 hover:bg-gray-100 transition rounded-lg">
                <div class="w-10 h-10 bg-red-500 text-white flex items-center justify-center rounded-full text-lg font-semibold">JD</div>
                <div>
                    <p class="text-gray-800 text-sm font-medium">Judul skripsi Anda ditolak. Alasan: Topik kurang sesuai.</p>
                    <span class="text-xs text-gray-500">5 jam yang lalu</span>
                </div>
            </div>
            <!-- Notifikasi Item -->
            <div class="flex items-start space-x-3 p-3 bg-gray-50 hover:bg-gray-100 transition rounded-lg">
                <div class="w-10 h-10 bg-green-500 text-white flex items-center justify-center rounded-full text-lg font-semibold">JD</div>
                <div>
                    <p class="text-gray-800 text-sm font-medium">Jadwal seminar telah ditentukan: 20 Agustus 2025.</p>
                    <span class="text-xs text-gray-500">1 hari yang lalu</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
