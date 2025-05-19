@extends('layouts.layoutmhs')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4 text-center">Pengajuan Tugas Akhir - Status Pending</h2>

    @if ($pengajuan->isEmpty())
        <p class="text-center text-gray-500 italic">Belum ada pengajuan yang pending.</p>
    @else
        @foreach ($pengajuan as $item)
        <div class="border rounded-lg p-4 mb-4 shadow-sm bg-gray-50">
            <p class="mb-1"><span class="font-semibold">Nama Mahasiswa:</span> {{ $item->mahasiswa->nama ?? '-' }}</p>
            <p class="mb-1"><span class="font-semibold">NIM:</span> {{ $item->mahasiswa->nim ?? '-' }}</p>
            <p class="mb-1"><span class="font-semibold">Judul Topik:</span> {{ $item->topik_ta }}</p>
            <p class="mb-1"><span class="font-semibold">Deskripsi:</span> {{ $item->deskripsi_ta }}</p>
            <p class="mb-1"><span class="font-semibold">Dosen Pembimbing 1:</span> {{ $item->dosen1->nama ?? '-' }}</p>
            <p class="mb-1"><span class="font-semibold">Dosen Pembimbing 2:</span> {{ $item->dosen2->nama ?? '-' }}</p>
            <p class="mb-1"><span class="font-semibold">Tanggal Pengajuan:</span> {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}</p>
            <p class="mb-1"><span class="font-semibold">Status:</span>
                <span class="text-yellow-600 font-semibold capitalize">{{ $item->status }}</span>
            </p>
        </div>
        @endforeach
    @endif
</div>
@endsection
