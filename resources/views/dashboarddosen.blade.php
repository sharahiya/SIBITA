@extends('layouts.layoutdosen')
@section('content')
    <div class="container mx-auto px-4 pt-4">
        <!-- Header -->
        <div class="bg-white p-5 shadow-md rounded-lg w-full max-w-5xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard Dosen</h1>
            <p class="text-gray-600 text-sm">Selamat datang, {{ $dosen->nama }}</p>
        </div>

        <!-- Statistik Kartu -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 max-w-5xl mx-auto">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Mahasiswa Bimbingan</h2>
                <p class="text-xl font-bold">{{ $bimbinganCount }}</p>
            </div>
            <div class="bg-emerald-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sempro</h2>
                <p class="text-xl font-bold">{{ $selesaiSempro }}</p>
            </div>
            <div class="bg-yellow-400 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Semhas</h2>
                <p class="text-xl font-bold">{{ $selesaiSemhas }}</p>
            </div>
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sidang</h2>
                <p class="text-xl font-bold">{{ $selesaiSidang }}</p>
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
                        @foreach($jadwalSaya as $jadwal)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-5 py-3">{{ $jadwal->mahasiswa->nama }}</td>
                            <td class="px-5 py-3">{{ $jadwal->mahasiswa->npm }}</td>
                            <td class="px-5 py-3">{{ $jadwal->jenis_ujian }}</td>
                            <td class="px-5 py-3">{{ $jadwal->topik_ta }}</td>
                            <td class="px-5 py-3">{{ $jadwal->peran }}</td>
                            <td class="px-5 py-3">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-5 py-3">{{ $jadwal->jam }}</td>
                            <td class="px-5 py-3">{{ $jadwal->ruangan }}</td>
                        </tr>
                        @endforeach
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
