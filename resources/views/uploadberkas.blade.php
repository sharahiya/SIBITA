@extends('layouts.layoutmhs')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl space-y-6">

    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h1 class="text-lg font-extrabold text-gray-800">Tugas Akhir Mahasiswa</h1> <!-- Judul lebih tegas -->
        <p class="text-sm text-gray-600">Informasi lengkap mengenai tugas akhir mahasiswa</p>
    </div>

    <!-- Data Mahasiswa -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-sm font-extrabold text-gray-800 mb-4">Data Mahasiswa</h2> <!-- Judul lebih tegas -->
        <div class="space-y-4 text-sm text-gray-700">
            <div>
                <span class="font-bold text-gray-900">Nama:</span> <span class="text-gray-700">Fauzan Ramadhan</span> <!-- Nama lebih tegas -->
            </div>
            <div>
                <span class="font-bold text-gray-900">NPM:</span> <span class="text-gray-700">2108107010011</span> <!-- NPM lebih tegas -->
            </div>
            <div>
                <span class="font-bold text-gray-900">Semester Sajian:</span> <span class="text-gray-700">Genap 2024</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">Dosen Wali:</span> <span class="text-gray-700">Dr. Ahmad S.Pd., M.Kom</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">NIP Dosen Wali:</span> <span class="text-gray-700">198012312007011001</span>
            </div>
        </div>
    </div>

    <!-- Informasi Tugas Akhir -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-sm font-extrabold text-gray-800 mb-4">Informasi Tugas Akhir</h2> <!-- Judul lebih tegas -->
        <div class="space-y-4 text-sm text-gray-700">
            <div>
                <span class="font-bold text-gray-900">Bidang Penelitian:</span> <span class="text-gray-700">Kecerdasan Buatan</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">Judul TA:</span> <span class="text-gray-700">Penerapan Deep Learning dalam Deteksi Emosi Wajah</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">Deskripsi:</span>
                <p class="text-gray-700 mt-1">Penelitian ini membangun model untuk mendeteksi emosi wajah menggunakan CNN dan dataset FER2013. Penelitian ini bertujuan untuk memahami berbagai ekspresi wajah yang dapat digunakan untuk deteksi emosi secara otomatis dalam berbagai aplikasi. Model yang dibangun diharapkan dapat meningkatkan akurasi sistem deteksi emosi.</p>
            </div>
            <div>
                <span class="font-bold text-gray-900">Dosen Pembimbing 1:</span> <span class="text-gray-700">Dr. Budi Santoso</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">Dosen Pembimbing 2:</span> <span class="text-gray-700">Dr. Rina Kurniawati</span>
            </div>
        </div>
    </div>

    <!-- Upload Berkas -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-sm font-extrabold text-gray-800 mb-4">Upload Berkas</h2> <!-- Judul lebih tegas -->
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6 text-sm text-gray-700">
            <!-- Berkas Sempro -->
            <div>
                <label class="font-bold block mb-1 text-blue-600">Bukti Seminar Proposal (JPG/PNG)</label>
                <input type="file" accept=".jpg,.jpeg,.png" class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Unggah bukti foto telah mengikuti Seminar Proposal.</p>
            </div>

            <!-- Berkas Semhas -->
            <div>
                <label class="font-bold block mb-1 text-blue-600">Bukti Seminar Hasil (JPG/PNG)</label>
                <input type="file" accept=".jpg,.jpeg,.png" class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Unggah bukti foto telah mengikuti Seminar Hasil.</p>
            </div>

            <!-- Berkas Sidang -->
            <div>
                <label class="font-bold block mb-1 text-green-600">File Final Sidang (PDF)</label>
                <input type="file" accept=".pdf" class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="text-xs text-gray-500 mt-1">Unggah file PDF final tugas akhir untuk sidang.</p>
            </div>

            <!-- Tombol -->
            <div class="pt-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition text-sm">
                    Simpan Berkas
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
