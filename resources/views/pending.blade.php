@extends('layouts.layoutmhs')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6 flex items-center justify-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M8 16l-4-4m0 0l4-4m-4 4h16" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Pengajuan Tugas Akhir
    </h2>

    @if ($pengajuan->isEmpty())
        <div class="text-center text-gray-500 italic">Belum ada pengajuan aktif.</div>
    @else
        @foreach ($pengajuan as $topik => $items)
            @php
                $first = $items->first();
                $dosen1 = $items->firstWhere('dosen_ke', 1);
                $dosen2 = $items->firstWhere('dosen_ke', 2);
            @endphp

            <div class="border border-gray-200 rounded-xl p-6 mb-6 bg-gray-50 shadow-sm space-y-4">
                {{-- Informasi Tugas Akhir --}}
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Informasi Tugas Akhir</p>
                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div><span class="font-semibold">Nama Mahasiswa:</span> {{ $first->mahasiswa->nama ?? '-' }}</div>
                        <div><span class="font-semibold">NIM:</span> {{ $first->mahasiswa->npm ?? '-' }}</div>
                        <div class="sm:col-span-2"><span class="font-semibold">Judul Topik:</span> {{ $first->topik_ta }}</div>
                        <div class="sm:col-span-2"><span class="font-semibold">Deskripsi:</span> {{ $first->deskripsi_ta }}</div>
                        <div class="sm:col-span-2"><span class="font-semibold">Tanggal Pengajuan:</span> {{ \Carbon\Carbon::parse($first->tanggal_pengajuan)->format('d M Y') }}</div>
                    </div>
                </div>

                {{-- Informasi Dosen Pembimbing --}}
                <hr>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Informasi Dosen Pembimbing</p>
                    <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
                        @if ($dosen1)
                            <div>
                                <span class="font-semibold">Dosen Pembimbing 1:</span> {{ $dosen1->dosen->nama ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Status Dosen 1:</span>
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                    {{ $dosen1->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($dosen1->status) }}
                                </span>
                                @if ($dosen1->status === 'ditolak')
                                    <a href="{{ route('pengajuan.ulang', ['ke' => 1, 'id' => $dosen1->id_pengajuan]) }}"
                                       class="ml-2 inline-block text-sm text-blue-600 hover:underline">
                                        Ajukan Ulang
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if ($dosen2)
                            <div>
                                <span class="font-semibold">Dosen Pembimbing 2:</span> {{ $dosen2->dosen->nama ?? '-' }}
                            </div>
                            <div>
                                <span class="font-semibold">Status Dosen 2:</span>
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                    {{ $dosen2->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($dosen2->status) }}
                                </span>
                                @if ($dosen2->status === 'ditolak')
                                    <a href="{{ route('pengajuan.ulang', ['ke' => 2, 'id' => $dosen2->id_pengajuan]) }}"
                                       class="ml-2 inline-block text-sm text-blue-600 hover:underline">
                                        Ajukan Ulang
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
