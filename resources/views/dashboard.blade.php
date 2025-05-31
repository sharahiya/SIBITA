@extends('layouts.layoutmhs')
@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-1">
    <div class="flex items-center space-x-4">
        @php
        $user = Auth::guard('mahasiswa')->user();
        $firstName = explode(' ', $user->nama)[0];
    @endphp

        <span class="w-14 h-14 flex items-center justify-center text-white bg-blue-400 rounded-full text-2xl">
            {{ strtoupper(substr($firstName, 0, 1)) }}
        </span>
        <div>

            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-x-2">
                Hi, {{ $mahasiswa->nama }}!
            </h2>
        </div>
    </div>

    <!-- Grid dengan 2 kolom untuk informasi mahasiswa -->
    <div class="mt-4 grid grid-cols-[30px_auto] gap-y-2 items-center">
        <i class="text-gray-500 fas fa-id-card"></i>
        <p class="text-sm text-gray-600">NPM : {{ $mahasiswa->npm }}</p>

        <i class="text-gray-500 fas fa-calendar-alt"></i>
        <p class="text-sm text-gray-600">Semester Sajian : Genap 2024/2025</p>

        <i class="text-gray-500 fas fa-chalkboard-teacher"></i>



        <p class="text-sm text-gray-600">Dosen Wali : {{ $mahasiswa->dosenWali->nama ?? 'Belum ditentukan' }}</p>

        <i class="text-gray-500 fas fa-id-badge"></i>
        <p class="text-sm text-gray-600">NIP Dosen Wali : {{ $mahasiswa->dosenWali->nip ?? '-' }}</p>
    </div>

  <!-- Informasi Dospem & Penguji -->
<div class="mt-6">
    <h2 class="text-md font-semibold text-gray-800">Dosen Pembimbing & Penguji</h2>
    <div class="grid grid-cols-2 gap-4 mt-2">
        <!-- Dospem 1 -->
        <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
            <i class="text-gray-600 fas fa-user-tie"></i>
            <div>
                <h3 class="text-sm text-gray-700">Dospem 1</h3>

                @if (!$dospem1)
                    <p class="text-xs text-gray-500">Belum ada data - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan</a></p>
                @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'pending')
                    <p class="text-xs text-yellow-600 italic">Menunggu persetujuan</p>
                @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'ditolak')
                    <p class="text-xs text-red-600">Ditolak - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan ulang</a></p>
                @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'diterima')
                    <p class="text-xs text-green-600 font-medium">{{ $dospem1->nama }}</p>
                @endif
            </div>
        </div>

        <!-- Dospem 2 -->
        <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
            <i class="text-gray-600 fas fa-user-tie"></i>
            <div>
                <h3 class="text-sm text-gray-700">Dospem 2</h3>
                @if (!$dospem2)
                    <p class="text-xs text-gray-500">Belum ada data - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan</a></p>
                @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'pending')
                    <p class="text-xs text-yellow-600 italic">Menunggu persetujuan</p>
                @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'ditolak')
                    <p class="text-xs text-red-600">Ditolak - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan ulang</a></p>
                @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'diterima')
                    <p class="text-xs text-green-600 font-medium">{{ $dospem2->nama }}</p>
                @endif
            </div>
        </div>

        <!-- Penguji 1 -->
        <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
            <i class="text-gray-600 fas fa-user-check"></i>
            <div>
                <h3 class="text-sm text-gray-700">Penguji 1</h3>
                @if (!$penguji1)
                    <p class="text-xs text-gray-500">Belum ada data</p>
                @else
                    <p class="text-xs text-green-600 font-medium">{{ $penguji1->nama }}</p>
                @endif
            </div>
        </div>

        <!-- Penguji 2 -->
        <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
            <i class="text-gray-600 fas fa-user-check"></i>
            <div>
                <h3 class="text-sm text-gray-700">Penguji 2</h3>
                @if (!$penguji2)
                    <p class="text-xs text-gray-500">Belum ada data</p>
                @else
                    <p class="text-xs text-green-600 font-medium">{{ $penguji2->nama }}</p>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-5 mt-8">
    <h2 class="text-lg font-bold text-gray-800 mb-6 text-center">📌 Status Mahasiswa</h2>
    @if(count($status))
        <ol class="relative border-s border-gray-200">
            @foreach($status as $item)
                <li class="mb-6 ms-3">
                    <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
                    <time class="text-xs text-gray-400">{{ $item['tanggal'] }}</time>
                    <h3 class="text-md font-semibold text-gray-900">{{ $item['judul'] }}</h3>
                    <p class="text-xs text-gray-500">{{ $item['deskripsi'] }}</p>
                </li>
            @endforeach
        </ol>
    @else
        <p class="text-center text-gray-500 text-sm">Belum ada progress yang dicatat.</p>
    @endif
</div>
<!-- Timeline Status Mahasiswa -->
{{-- <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-5 mt-8">
    <h2 class="text-lg font-bold text-gray-800 mb-6 text-center">📌 Status Mahasiswa</h2>
    <ol class="relative border-s border-gray-200">
        <li class="mb-6 ms-3">
            <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
            <time class="text-xs text-gray-400">18 Januari 2024</time>
            <h3 class="text-md font-semibold text-gray-900">Pengajuan Bimbingan</h3>
            <p class="text-xs text-gray-500">Selamat Pengajuan Anda Diterima!</p>
        </li>
        <li class="mb-6 ms-3">
            <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
            <time class="text-xs text-gray-400">21 Maret 2024</time>
            <h3 class="text-md font-semibold text-gray-900">Seminar Proposal</h3>
            <p class="text-xs text-gray-500">Selamat Pengajuan Anda Diterima!</p>
        </li>
        <li class="mb-6 ms-3">
            <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
            <time class="text-xs text-gray-400">28 April 2024</time>
            <h3 class="text-md font-semibold text-gray-900">Seminar Hasil</h3>
            <p class="text-xs text-gray-500">Selamat Pengajuan Anda Diterima!</p>
        </li>
        <li class="ms-3">
            <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
            <time class="text-xs text-gray-400">30 Mei 2024</time>
            <h3 class="text-md font-semibold text-gray-900">Sidang</h3>
            <p class="text-xs text-gray-500">Selamat Pengajuan Anda Diterima!</p>
        </li>
    </ol>
</div> --}}



<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }

    .animate-slide-in {
        animation: slide-in 1s ease-out;
    }

    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    .delay-300 { animation-delay: 0.6s; }
</style>

@endsection
