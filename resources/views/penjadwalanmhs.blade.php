<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    .table-container {
    max-height: 400px;
    overflow-x: auto; /* Pastikan tabel bisa digeser ke samping */
    overflow-y: auto; 
    white-space: nowrap; /* Mencegah seluruh tabel menyusut */
}

.judul-ta {
    white-space: normal;  /* Memungkinkan teks turun ke bawah */
    word-wrap: break-word; /* Memastikan teks bisa dipotong */
    max-width: 350px; /* Tambah panjang kolom Judul TA */
    min-width: 350px; /* Pastikan tetap besar */
    overflow-wrap: break-word; /* Alternatif untuk memotong teks */
}


    .penguji-table {
        width: 100%;
        border-collapse: collapse;
    }
    .penguji-table td {
        border: 1px solid gray;
        padding: 6px;
        text-align: center;
        font-size: 12px;
    }
</style>

</head>
<body class="bg-blue-100 font-poppins min-h-screen flex flex-col">
    
    <!-- Navbar -->
    @include('components/navbar')

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto mt-16">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Jadwal Seminar Mahasiswa</h1>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
                <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                    <thead class="text-[10px] text-white uppercase bg-blue-900">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">No</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Nama</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">NPM</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Judul TA</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Dospem 1</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Dospem 2</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Penguji</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Tanggal Sempro</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Tanggal Semhas</th>
                            <th class="px-4 py-2 border border-gray-300 fixed-cell">Tanggal Sidang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>1</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Ahmad Fauzan</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>210810701001</td>
                            <td class='px-4 py-2 border border-gray-300 judul-ta'>
                                Rancang Bangun Sistem Manajemen Pengajuan Tugas Akhir Berbasis Website Menggunakan Metode RAD
                            </td>

                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dr. Budi Santoso<br><span class='text-gray-500'>123456789</span></td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dr. Siti Aminah<br><span class='text-gray-500'>987654321</span></td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>
                            <table class="penguji-table">
                                <tr><td>Prof. Indra Wijaya</td></tr>
                                <tr><td>Dr. Lestari Kusuma</td></tr>
                            </table>
                        </td>

                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>10-05-2024 | 08:00</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>15-06-2024 | 10:00</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>20-07-2024 | 13:00</td>
                        </tr>
                        <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>2</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Siti Rahmawati</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>210810701002</td>
                            <td class='px-4 py-2 border border-gray-300 judul-ta'>
                        Rancang Bangun Sistem Manajemen Pengajuan Tugas Akhir Berbasis Website Menggunakan Metode RAD
                            </td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dr. Andi Wijaya<br><span class='text-gray-500'>123123123</span></td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>Dr. Rina Sari<br><span class='text-gray-500'>321321321</span></td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>
                                <table class="penguji-table">
                                    <tr><td>Prof. Wahyu Setiawan</td></tr>
                                    <tr><td>Dr. Hendra Kusnadi</td></tr>
                                </table>
                            </td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>12-05-2024 | 09:00</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>17-06-2024 | 11:00</td>
                            <td class='px-4 py-2 border border-gray-300 fixed-cell'>22-07-2024 | 14:00</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    @include('components/footer')
</body>
</html>