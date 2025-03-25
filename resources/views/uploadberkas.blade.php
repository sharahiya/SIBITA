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
</head>
<body class="bg-blue-100 font-poppins min-h-screen flex flex-col items-center p-4">

    <!-- Navbar -->
    @include('components/navbar')

    <div class="max-w-3xl w-full bg-white shadow-md rounded-lg p-6 mt-16 fade-in">
        <h2 class="text-lg font-semibold text-primary border-b pb-2 flex items-center">
            <i class="fas fa-user-graduate text-accent mr-2"></i> Informasi Mahasiswa
        </h2>
        <div class="mt-3 text-secondary space-y-2 text-sm">
            <p><span class="font-medium text-primary">Nama:</span> Sharahiya</p>
            <p><span class="font-medium text-primary">NPM:</span> 2108107010082</p>
            <p><span class="font-medium text-primary">Semester Sajian:</span> Genap 2024/2025</p>
            <p><span class="font-medium text-primary">Dosen Wali:</span> Dr. Muzailin, S.Si., M.Sc.</p>
            <p><span class="font-medium text-primary">NIP Dosen Wali:</span> 197001011992031002</p>
        </div>

        <div id="ta-info" class="mt-4">
            <h3 class="text-lg font-semibold text-primary border-b pb-2 flex items-center">
                <i class="fas fa-book text-accent mr-2"></i> Informasi Tugas Akhir
            </h3>
            <div class="text-secondary space-y-2 mt-3 text-sm">
                <p><span class="font-medium text-primary">Bidang Penelitian:</span> [Belum tersedia]</p>
                <p><span class="font-medium text-primary">Judul TA:</span> [Belum tersedia]</p>
                <p><span class="font-medium text-primary">Deskripsi TA:</span> [Belum tersedia]</p>
                <p><span class="font-medium text-primary">Dospem 1:</span> [Belum tersedia]</p>
                <p><span class="font-medium text-primary">Dospem 2:</span> [Belum tersedia]</p>
            </div>
        </div>

        <div class="mt-4">
    <h3 class="text-lg font-semibold text-primary border-b pb-2 flex items-center">
        <i class="fas fa-upload text-accent mr-2"></i> Upload Berkas
    </h3>
    <form class="mt-3 space-y-4" id="uploadForm">
        <div class="space-y-2">
            <div>
                <label for="sempro" class="block text-secondary text-xs font-medium">
                    <span class="font-medium text-primary">Upload Berkas Seminar Proposal:</span>
                </label>
                <input type="file" id="sempro" class="w-full border p-2 rounded focus:ring-accent text-xs">
                <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded hover:bg-blue-700 text-xs">
                    Submit
                </button>
            </div>
            <div>
                <label for="semhas" class="block text-secondary text-xs font-medium">
                    <span class="font-medium text-primary">Upload Berkas Seminar Hasil:</span>
                </label>
                <input type="file" id="semhas" class="w-full border p-2 rounded focus:ring-accent text-xs">
                <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded hover:bg-blue-700 text-xs">
                    Submit
                </button>
            </div>
            <div>
                <label for="sidang" class="block text-secondary text-xs font-medium">
                    <span class="font-medium text-primary">Upload Berkas Sidang:</span>
                </label>
                <input type="file" id="sidang" class="w-full border p-2 rounded focus:ring-accent text-xs">
                <button type="submit" class="mt-2 bg-accent text-white px-4 py-2 rounded hover:bg-blue-700 text-xs">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>


</body>
</html>
