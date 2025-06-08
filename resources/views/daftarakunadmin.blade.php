@extends('layouts.layoutadmin')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Daftar Mahasiswa & Dosen</h1>
        <p class="text-gray-600 text-sm">Lihat daftar mahasiswa dan dosen yang terdaftar di sistem</p>
    </div>

    <!-- Mahasiswa Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Mahasiswa</h2>
            <input type="text" placeholder="Cari mahasiswa..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NPM</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Angkatan</th>
                            <th class="px-4 py-2">NIP Dosen Wali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 12; $i++)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">Mahasiswa {{ $i }}</td>
                            <td class="px-4 py-2">21081010{{ sprintf("%03d", $i) }}</td>
                            <td class="px-4 py-2">mhs{{ $i }}@example.com</td>
                            <td class="px-4 py-2">202{{ $i % 3 + 1 }}</td>
                            <td class="px-4 py-2">19800{{ $i }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dosen Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Dosen</h2>
            <input type="text" placeholder="Cari dosen..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 10; $i++)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-4 py-2">Dosen {{ $i }}</td>
                            <td class="px-4 py-2">19800{{ $i }}</td>
                            <td class="px-4 py-2">dosen{{ $i }}@example.com</td>
                            <td class="px-4 py-2">{{ $i % 2 == 0 ? 'Lektor' : 'Guru Besar' }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
