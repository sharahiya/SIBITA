@extends('layouts.layoutadmin')

@section('content')
<div class="container mx-auto px-4 pt-4">
    <!-- Header -->
    <div class="bg-white p-5 shadow-md rounded-lg w-full max-w-5xl mx-auto">
        <h1 class="text-xl font-semibold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 text-sm">Selamat datang, Admin!</p>
    </div>

    <!-- Statistik Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 max-w-5xl mx-auto">
        <div class="bg-blue-600 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
            <h2 class="text-lg font-semibold">Jumlah Mahasiswa</h2>
            <p class="text-2xl font-bold">250</p>
        </div>
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
            <h2 class="text-lg font-semibold">Jumlah Dosen</h2>
            <p class="text-2xl font-bold">30</p>
        </div>
        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
            <h2 class="text-lg font-semibold">Mahasiswa Aktif TA</h2>
            <p id="jumlahAktifTA" class="text-2xl font-bold">120</p>
        </div>
    </div>

    <!-- Rekap Penyelesaian Mahasiswa -->
    <div class="bg-white p-4 mt-6 shadow-md rounded-lg max-w-5xl mx-auto hover:shadow-lg transition-all duration-300">
        <h2 class="text-md font-semibold text-gray-800 mb-2">Rekap Penyelesaian Mahasiswa</h2>
        <p class="text-xs text-gray-500 mb-4">Pilih Tahun Ajaran dan Semester</p>

        <!-- Dropdown -->
        <div class="flex space-x-4 mb-4">
            <select id="tahunAjaran" class="form-select block w-1/3 p-2 bg-gray-100 border border-gray-300 rounded-md text-xs">
                <option value="2024/2025">2024/2025</option>
                <option value="2023/2024">2023/2024</option>
                <option value="2022/2023">2022/2023</option>
            </select>

            <select id="semester" class="form-select block w-1/3 p-2 bg-gray-100 border border-gray-300 rounded-md text-xs">
                <option value="Genap">Semester Genap</option>
                <option value="Ganjil">Semester Ganjil</option>
            </select>
        </div>

        <!-- Data Penyelesaian -->
        <div class="space-y-3">
            <div class="flex justify-between text-gray-700 text-xs hover:bg-gray-50 transition-all duration-200 rounded-lg p-2">
                <span>Jumlah Mahasiswa Selesai Seminar Proposal</span>
                <span id="jumlahSempro" class="font-semibold text-blue-600">45 Mahasiswa</span>
            </div>
            <div class="flex justify-between text-gray-700 text-xs hover:bg-gray-50 transition-all duration-200 rounded-lg p-2">
                <span>Jumlah Mahasiswa Selesai Seminar Hasil</span>
                <span id="jumlahSemhas" class="font-semibold text-green-600">38 Mahasiswa</span>
            </div>
            <div class="flex justify-between text-gray-700 text-xs hover:bg-gray-50 transition-all duration-200 rounded-lg p-2">
                <span>Jumlah Mahasiswa Selesai Sidang Skripsi</span>
                <span id="jumlahSidang" class="font-semibold text-yellow-600">25 Mahasiswa</span>
            </div>
        </div>
    </div>

    <!-- Penjadwalan Terdekat -->
    <div class="bg-white p-4 shadow-md rounded-lg mt-6 max-w-5xl mx-auto">
        <h2 class="text-md font-semibold text-gray-800 mb-4">Penjadwalan Terdekat</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">Nama Mahasiswa</th>
                        <th class="px-3 py-2">NPM</th>
                        <th class="px-3 py-2">Jenis Ujian</th>
                        <th class="px-3 py-2">Judul TA</th>
                        <th class="px-3 py-2">Peran</th>
                        <th class="px-3 py-2">Tanggal</th>
                        <th class="px-3 py-2">Waktu</th>
                        <th class="px-3 py-2">Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-3 py-2">Sharahiya</td>
                        <td class="px-3 py-2">2108107010082</td>
                        <td class="px-3 py-2">Seminar Proposal</td>
                        <td class="px-3 py-2">Analisis AI dalam Pendidikan</td>
                        <td class="px-3 py-2">Dosen Pembimbing</td>
                        <td class="px-3 py-2">12 Juli 2024</td>
                        <td class="px-3 py-2">10.00 - Selesai</td>
                        <td class="px-3 py-2">Ruang 101</td>
                    </tr>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-3 py-2">Fatiya Quzza</td>
                        <td class="px-3 py-2">2108107010030</td>
                        <td class="px-3 py-2">Seminar Hasil</td>
                        <td class="px-3 py-2">Blockchain untuk Keamanan Data</td>
                        <td class="px-3 py-2">Penguji</td>
                        <td class="px-3 py-2">15 Juli 2024</td>
                        <td class="px-3 py-2">14.00 - Selesai</td>
                        <td class="px-3 py-2">Ruang 102</td>
                    </tr>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-3 py-2">Tyara Rayna</td>
                        <td class="px-3 py-2">2108107010082</td>
                        <td class="px-3 py-2">Sidang Skripsi</td>
                        <td class="px-3 py-2">Sistem IoT untuk Smart Home</td>
                        <td class="px-3 py-2">Penguji</td>
                        <td class="px-3 py-2">20 Juli 2024</td>
                        <td class="px-3 py-2">08.00 - Selesai</td>
                        <td class="px-3 py-2">Aula Besar</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Dynamic Update Data -->
<script>
    document.getElementById('tahunAjaran').addEventListener('change', updateData);
    document.getElementById('semester').addEventListener('change', updateData);

    function updateData() {
        const tahun = document.getElementById('tahunAjaran').value;
        const semester = document.getElementById('semester').value;

        // Dummy Data - ini simulasi, nanti kalau mau real bisa fetch dari API atau query DB
        let data = {
            '2024/2025': {
                'Genap': { aktif: 120, sempro: 45, semhas: 38, sidang: 25 },
                'Ganjil': { aktif: 100, sempro: 40, semhas: 32, sidang: 20 },
            },
            '2023/2024': {
                'Genap': { aktif: 95, sempro: 35, semhas: 28, sidang: 18 },
                'Ganjil': { aktif: 80, sempro: 30, semhas: 22, sidang: 15 },
            },
            '2022/2023': {
                'Genap': { aktif: 70, sempro: 25, semhas: 20, sidang: 10 },
                'Ganjil': { aktif: 60, sempro: 20, semhas: 15, sidang: 8 },
            }
        };

        let selected = data[tahun][semester];
        document.getElementById('jumlahAktifTA').innerText = selected.aktif;
        document.getElementById('jumlahSempro').innerText = `${selected.sempro} Mahasiswa`;
        document.getElementById('jumlahSemhas').innerText = `${selected.semhas} Mahasiswa`;
        document.getElementById('jumlahSidang').innerText = `${selected.sidang} Mahasiswa`;
    }
</script>

@endsection
