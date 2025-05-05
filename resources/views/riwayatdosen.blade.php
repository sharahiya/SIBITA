@extends('layouts.layoutdosen')
@section('content') 
    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }
        .judul-ta {
            white-space: normal;
            word-wrap: break-word;
            max-width: 300px; /* Lebih lebar */
        }
        .bidang-minat {
            width: 100px; /* Lebih kecil */
            text-align: center;
        }
        .role {
            width: 120px; /* Ukuran kolom Role */
            text-align: center;
        }
        .search-wrapper {
            position: relative;
            width: 350px; /* Memperpanjang lebar search bar */
        }
        .search-wrapper input {
            width: 100%;
            padding: 8px 30px 8px 10px; /* Mengatur padding untuk memberikan ruang bagi ikon */
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        .search-wrapper .fa-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #888;
        }
    </style>


    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">
            
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold text-gray-800">Riwayat Mahasiswa Bimbingan</h1>
                <div class="search-wrapper">
                    <input type="text" id="searchInput" placeholder="Cari Nama...">
                    <i class="fa fa-search"></i> <!-- Ikon pencarian -->
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
                <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                    <thead class="text-[10px] text-white uppercase bg-blue-900">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Nama</th>
                            <th class="px-4 py-2 border border-gray-300">NPM</th>
                            <th class="px-4 py-2 border border-gray-300 bidang-minat">Bidang Minat</th>
                            <th class="px-4 py-2 border border-gray-300 judul-ta">Judul TA</th>
                            <th class="px-4 py-2 border border-gray-300 role">Role</th>
                            <th class="px-4 py-2 border border-gray-300">File Final</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900'>1</td>
                            <td class='px-4 py-2 border border-gray-300'>Ahmad Fauzan</td>
                            <td class='px-4 py-2 border border-gray-300'>210810701001</td>
                            <td class='px-4 py-2 border border-gray-300 bidang-minat'>RPL</td>
                            <td class='px-4 py-2 border border-gray-300 judul-ta'>
                                Rancang Bangun Sistem Manajemen Pengajuan Tugas Akhir Berbasis Website Menggunakan Metode RAD
                            </td>
                            <td class='px-4 py-2 border border-gray-300 role'>Dospem 1</td>
                            <td class='px-4 py-2 border border-gray-300 text-center'>
                                <a href="path/to/file1.pdf" class="text-blue-600 hover:underline" download>
                                    <i class="fa fa-file-pdf text-red-600"></i> Download
                                </a>
                            </td>
                            <td class='px-4 py-2 border border-gray-300 text-green-600 font-semibold'>Selesai</td>
                        </tr>
                        <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                            <td class='px-4 py-2 border border-gray-300 font-medium text-gray-900'>2</td>
                            <td class='px-4 py-2 border border-gray-300'>Siti Rahmawati</td>
                            <td class='px-4 py-2 border border-gray-300'>210810701002</td>
                            <td class='px-4 py-2 border border-gray-300 bidang-minat'>DM</td>
                            <td class='px-4 py-2 border border-gray-300 judul-ta'>
                                Implementasi Algoritma Apriori dalam Menganalisis Pola Pembelian Konsumen
                            </td>
                            <td class='px-4 py-2 border border-gray-300 role'>Dospem 2</td>
                            <td class='px-4 py-2 border border-gray-300 text-center'>
                                <a href="path/to/file2.pdf" class="text-blue-600 hover:underline" download>
                                    <i class="fa fa-file-pdf text-red-600"></i> Download
                                </a>
                            </td>
                            <td class='px-4 py-2 border border-gray-300 text-green-600 font-semibold'>Selesai</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Script untuk fitur pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                let nama = row.cells[1].textContent.toLowerCase();
                if (nama.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>


@endsection