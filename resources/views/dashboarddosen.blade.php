@extends('layouts.layoutdosen')
@section('content')    
    <div class="container mx-auto px-4 pt-4">
        <!-- Header -->
        <div class="bg-white p-5 shadow-md rounded-lg w-full max-w-5xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard Dosen</h1>
            <p class="text-gray-600 text-sm">Selamat datang, Prof. Dr. Taufik Fuadi Abidin!</p>
        </div>

        <!-- Statistik Kartu -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 max-w-5xl mx-auto">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Mahasiswa Bimbingan</h2>
                <p class="text-xl font-bold">10</p>
            </div>
            <div class="bg-emerald-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sempro</h2>
                <p class="text-xl font-bold">7</p>
            </div>
            <div class="bg-yellow-400 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Semhas</h2>
                <p class="text-xl font-bold">5</p>
            </div>
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sidang</h2>
                <p class="text-xl font-bold">3</p>
            </div>
        </div>

        <!-- Jadwal Dosen sebagai Penguji/Dospem -->
        <div class="bg-white p-5 shadow-md rounded-lg mt-6 max-w-5xl mx-auto animate-fadeIn">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Saya</h2>
            <div class="overflow-y-auto max-h-60">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-5 py-3">Nama Mahasiswa</th>
                            <th class="px-5 py-3">NPM</th>
                            <th class="px-5 py-3">Jenis Ujian</th>
                            <th class="px-5 py-3">Judul TA</th>
                            <th class="px-5 py-3">Peran</th>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Ruangan</th> <!-- Kolom Ruangan -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-5 py-3">Sharahiya</td>
                            <td class="px-5 py-3">2108107010082</td>
                            <td class="px-5 py-3">Seminar Proposal</td>
                            <td class="px-5 py-3">Analisis AI dalam Pendidikan</td>
                            <td class="px-5 py-3">Dosen Pembimbing</td>
                            <td class="px-5 py-3">12 Juli 2024</td>
                            <td class="px-5 py-3">10.00 - Selesai</td>
                            <td class="px-5 py-3">Ruang 101</td> <!-- Ruangan -->
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-5 py-3">Fatiya Quzza</td>
                            <td class="px-5 py-3">2108107010030</td>
                            <td class="px-5 py-3">Seminar Hasil</td>
                            <td class="px-5 py-3">Blockchain untuk Keamanan Data</td>
                            <td class="px-5 py-3">Penguji</td>
                            <td class="px-5 py-3">15 Juli 2024</td>
                            <td class="px-5 py-3">14.00 - Selesai</td>
                            <td class="px-5 py-3">Ruang 102</td> <!-- Ruangan -->
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-5 py-3">Tyara Rayna</td>
                            <td class="px-5 py-3">2108107010082</td>
                            <td class="px-5 py-3">Sidang Skripsi</td>
                            <td class="px-5 py-3">Sistem IoT untuk Smart Home</td>
                            <td class="px-5 py-3">Penguji</td>
                            <td class="px-5 py-3">20 Juli 2024</td>
                            <td class="px-5 py-3">08.00 - Selesai</td>
                            <td class="px-5 py-3">Aula Besar</td> <!-- Ruangan -->
                        </tr>
                        <!-- Tambahkan data jadwal lainnya sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

@endsection
