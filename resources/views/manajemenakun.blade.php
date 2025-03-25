<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun</title>
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
    
    <div class="container mx-auto px-4 pt-4 max-w-5xl">
        <!-- Header -->
        <div class="bg-white p-6 shadow-md rounded-lg w-full mt-16 mx-auto">
            <h1 class="text-lg font-semibold text-gray-800">Manajemen Akun</h1>
            <p class="text-gray-600 text-sm">Tambah atau kelola akun mahasiswa dan dosen</p>
        </div>

        <!-- Form Input Data -->
        <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
            <h2 class="text-base font-semibold text-gray-800 mb-3">Tambah Akun</h2>
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" placeholder="Nama Lengkap" class="p-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                <input type="text" placeholder="NPM / NIDN" class="p-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                <input type="email" placeholder="Email" class="p-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                <select class="p-2 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Jenis Akun</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
                <button class="col-span-1 md:col-span-3 bg-blue-500 text-white p-2 text-sm rounded-lg hover:bg-blue-600 transition">Tambah Akun</button>
            </form>
        </div>

        <!-- Daftar Akun -->
        <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
            <h2 class="text-base font-semibold text-gray-800 mb-3">Daftar Akun</h2>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">NPM / NIDN</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Jenis Akun</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                        <td class="px-4 py-2">Fauzan Ramadhan</td>
                        <td class="px-4 py-2">2108107010021</td>
                        <td class="px-4 py-2">fauzan@email.com</td>
                        <td class="px-4 py-2">Mahasiswa</td>
                        <td class="px-4 py-2">
                            <button class="text-yellow-500 hover:text-yellow-600 text-sm mr-1">Edit</button>
                            <button class="text-red-500 hover:text-red-600 text-sm">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    @include('components/footer')
</body>
</html>
