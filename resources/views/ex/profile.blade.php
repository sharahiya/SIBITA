<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tugas Akhir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
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
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

    <!-- Navbar -->
    @include('components/navbar')
<body class="bg-gray-100 font-poppins min-h-screen flex flex-col items-center p-6">


    <div class="max-w-3xl w-full bg-white shadow-lg rounded-lg p-6 fade-in">
        <h2 class="text-2xl font-semibold text-primary border-b pb-2 flex items-center">
            <i class="fas fa-user-graduate text-accent mr-2"></i> Informasi Mahasiswa
        </h2>
        <div class="mt-4 text-secondary space-y-2">
            <p><strong>Nama:</strong> Sharahiya</p>
            <p><strong>NPM:</strong> 2108107010082</p>
            <p><strong>Semester Sajian:</strong> Genap 2024/2025</p>
            <p><strong>Dosen Wali:</strong> Dr Muzailin S.Si, M.Sc.</p>
            <p><strong>NIP Dosen Wali:</strong> 197001011992031002</p>
        </div>

        <div id="ta-info" class="mt-6">
            <h3 class="text-xl font-semibold text-primary border-b pb-2 flex items-center">
                <i class="fas fa-book text-accent mr-2"></i> Informasi Tugas Akhir
            </h3>
            <div class="text-secondary space-y-2 mt-2">
                <p><strong>Bidang Penelitian:</strong> [Muncul setelah pengajuan bimbingan]</p>
                <p><strong>Judul TA:</strong> [Muncul setelah pengajuan bimbingan]</p>
                <p><strong>Deskripsi TA:</strong> [Muncul setelah pengajuan bimbingan]</p>
                <p><strong>Dospem 1:</strong> [Muncul setelah pengajuan bimbingan]</p>
                <p><strong>Dospem 2:</strong> [Muncul setelah pengajuan bimbingan]</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold text-primary border-b pb-2 flex items-center">
                <i class="fas fa-upload text-accent mr-2"></i> Upload Berkas
            </h3>
            <form class="mt-4 space-y-4">
                <div>
                    <label class="block text-secondary">Upload Berkas Sempro:</label>
                    <input type="file" class="w-full border p-2 rounded-lg focus:ring-accent">
                    <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded-lg hover:bg-blue-700">Submit</button>
                </div>
                <div>
                    <label class="block text-secondary">Upload Berkas Semhas:</label>
                    <input type="file" class="w-full border p-2 rounded-lg focus:ring-accent">
                    <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded-lg hover:bg-blue-700">Submit</button>
                </div>
                <div>
                    <label class="block text-secondary">Upload Berkas Sidang:</label>
                    <input type="file" class="w-full border p-2 rounded-lg focus:ring-accent">
                    <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded-lg hover:bg-blue-700">Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>