<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
            },
        },
    };
    </script>
</head>
<body class="font-poppins bg-blue-100 min-h-screen flex flex-col">
    
    <!-- Navbar -->
    @include('components/navbaradmin')
    
    <div class="container mx-auto px-4 pt-4">
        <!-- Header -->
        <div class="bg-white p-6 shadow-md rounded-lg w-full max-w-5xl mt-16 mx-auto">
            <h1 class="text-2xl font-semibold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-600 text-sm">Selamat datang, Admin!</p>
        </div>

        <!-- Statistik Pengajuan Mahasiswa -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 max-w-5xl mx-auto">
            <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg cursor-pointer" onclick="filterDosen('RPL')">
                <h2 class="text-lg font-semibold">Mengajukan</h2>
                <p class="text-3xl font-bold">50</p>
            </div>
            <div class="bg-yellow-400 text-white p-6 rounded-xl shadow-lg cursor-pointer" onclick="filterDosen('DM')">
                <h2 class="text-lg font-semibold">Menunggu</h2>
                <p class="text-3xl font-bold">20</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg cursor-pointer" onclick="filterDosen('Jaringan')">
                <h2 class="text-lg font-semibold">Diterima</h2>
                <p class="text-3xl font-bold">25</p>
            </div>
            <div class="bg-red-500 text-white p-6 rounded-xl shadow-lg cursor-pointer" onclick="filterDosen('GIS')">
                <h2 class="text-lg font-semibold">Ditolak</h2>
                <p class="text-3xl font-bold">5</p>
            </div>
        </div>

        <!-- Filter Dosen berdasarkan Bidang Minat -->
        <div class="max-w-5xl mx-auto mt-6">
            <div class="flex border-b">
                <button class="tab px-5 py-3 text-gray-600 border-b-2 border-transparent hover:border-blue-500" onclick="filterDosen('RPL')">RPL</button>
                <button class="tab px-5 py-3 text-gray-600 border-b-2 border-transparent hover:border-blue-500" onclick="filterDosen('DM')">DM</button>
                <button class="tab px-5 py-3 text-gray-600 border-b-2 border-transparent hover:border-blue-500" onclick="filterDosen('Jaringan')">Jaringan</button>
                <button class="tab px-5 py-3 text-gray-600 border-b-2 border-transparent hover:border-blue-500" onclick="filterDosen('GIS')">GIS</button>
            </div>
        </div>

        <!-- Daftar Dosen dan Pengajuan -->
        <div class="bg-white p-6 shadow-md rounded-lg mt-6 max-w-5xl mx-auto animate-fadeIn">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Dosen</h2>
            <div class="overflow-y-auto max-h-60">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Nama Dosen</th>
                            <th class="px-6 py-3">Bidang Minat</th>
                            <th class="px-6 py-3">Total Bimbingan</th>
                            <th class="px-6 py-3">Sudah Sempro</th>
                            <th class="px-6 py-3">Sudah Semhas</th>
                            <th class="px-6 py-3">Sudah Sidang</th>
                        </tr>
                    </thead>
                    <tbody id="dosen-list">
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4">Dr. Ahmad Syarif</td>
                            <td class="px-6 py-4">RPL</td>
                            <td class="px-6 py-4">20</td>
                            <td class="px-6 py-4">10</td>
                            <td class="px-6 py-4">5</td>
                            <td class="px-6 py-4">3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filterDosen(bidang) {
            let rows = document.querySelectorAll("#dosen-list tr");
            rows.forEach(row => {
                let bidangDosen = row.cells[1].textContent.trim();
                row.style.display = (bidangDosen === bidang) ? "table-row" : "none";
            });
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        .tab.active {
            border-bottom-color: blue;
            color: blue;
        }
    </style>

    <!-- Footer -->
    @include('components/footer')
</body>
</html>
