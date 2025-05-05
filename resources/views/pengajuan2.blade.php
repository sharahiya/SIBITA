@extends('layouts.layoutmhs')
@section('content')

    <div class="container mx-auto max-w-3xl flex-grow">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Status Pengajuan Dosen Pembimbing</h2>

           <!-- Tambahan di bagian Dosen Pembimbing 1 -->
<div class="mb-4 p-4 border-l-4 border-green-500 bg-green-50 rounded">
    <h3 class="text-md font-medium text-green-700">Dosen Pembimbing 1</h3>
    <p class="text-sm text-green-700">
        Pengajuan Anda telah <strong>diterima</strong> oleh <strong>Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech</strong>.
    </p>

    <!-- Tombol Lihat Teman Seperbimbingan -->
    <div class="mt-2">
        <a href="detaildospem1" class="inline-block text-sm bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 transition">Lihat Kelas</a>
    </div>
</div>

            <!-- Dosen Pembimbing 2 -->
            <div class="mb-4 p-4 border-l-4 border-red-500 bg-red-50 rounded">
                <h3 class="text-md font-medium text-red-700">Dosen Pembimbing 2</h3>
                <p class="text-sm text-red-700">
                    Pengajuan Anda <strong>ditolak</strong> oleh <strong>Dr. Rina Marlina</strong>.
                </p>
                <p class="text-xs text-red-600 italic mt-1">
                    Alasan: Topik tidak sesuai dengan bidang keahlian saya.
                </p>
            </div>

            <div class="text-sm text-gray-700">
                Silakan ajukan ulang untuk memilih Dosen Pembimbing 2 yang lain.
            </div>

            <div class="mt-4 text-center">
                <a href="/pengajuan" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Ajukan Ulang</a>
            </div>
        </div>
    </div>

@endsection
