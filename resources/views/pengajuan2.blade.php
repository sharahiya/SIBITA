@extends('layouts.layoutmhs')

@section('content')
<div class="container mx-auto max-w-3xl flex-grow">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Status Pengajuan Dosen Pembimbing</h2>

        {{-- Dosen Pembimbing 1 --}}
        @if ($pengajuan1)
            <div class="mb-4 p-4 border-l-4
                @if ($pengajuan1->status === 'diterima')
                    border-green-500 bg-green-50
                @elseif ($pengajuan1->status === 'ditolak')
                    border-red-500 bg-red-50
                @else
                    border-yellow-500 bg-yellow-50
                @endif
                rounded">
                <h3 class="text-md font-medium
                    @if ($pengajuan1->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan1->status === 'ditolak')
                        text-red-700
                    @else
                        text-yellow-700
                    @endif
                ">Dosen Pembimbing 1</h3>

                <p class="text-sm
                    @if ($pengajuan1->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan1->status === 'ditolak')
                        text-red-700
                    @else
                        text-yellow-700
                    @endif
                ">
                    Pengajuan Anda <strong>{{ $pengajuan1->status }}</strong>
                    @if ($pengajuan1->dosen)
                        oleh <strong>{{ $pengajuan1->dosen->nama }}</strong>.
                    @endif
                </p>

                {{-- Show rejection reason for Pembimbing 1 --}}
                @if ($pengajuan1->status === 'ditolak' && !empty($pengajuan1->alasan_ditolak))
                    <div class="mt-3 p-3 bg-red-100 border-l-4 border-red-400 rounded">
                        <p class="text-sm text-red-700 font-medium">Alasan Penolakan:</p>
                        <p class="text-sm text-red-600 mt-1">{{ $pengajuan1->alasan_ditolak }}</p>
                    </div>
                @endif

                {{-- Fixed: Check $pengajuan1 status instead of $pengajuan2 --}}
                @if ($pengajuan1->status === 'ditolak')
                    <div class="text-sm text-gray-700 mt-3">
                        Silakan ajukan ulang untuk memilih Dosen Pembimbing 1 yang lain.
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Ajukan Ulang</a>
                    </div>
                @endif

                @if ($pengajuan1->status === 'diterima')
                    <div class="mt-2">
                        <a href="{{ route('detail.dosen', $pengajuan1->dosen->id_dosen) }}" class="inline-block text-sm bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 transition">Lihat Kelas</a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Dosen Pembimbing 2 --}}
        @if ($pengajuan2)
            <div class="mb-4 p-4 border-l-4
                @if ($pengajuan2->status === 'diterima')
                    border-green-500 bg-green-50
                @elseif ($pengajuan2->status === 'ditolak')
                    border-red-500 bg-red-50
                @else
                    border-yellow-500 bg-yellow-50
                @endif
                rounded">
                <h3 class="text-md font-medium
                    @if ($pengajuan2->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan2->status === 'ditolak')
                        text-red-700
                    @else
                        text-yellow-700
                    @endif
                ">Dosen Pembimbing 2</h3>

                <p class="text-sm
                    @if ($pengajuan2->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan2->status === 'ditolak')
                        text-red-700
                    @else
                        text-yellow-700
                    @endif
                ">
                    Pengajuan Anda <strong>{{ $pengajuan2->status }}</strong>
                    @if ($pengajuan2->dosen)
                        oleh <strong>{{ $pengajuan2->dosen->nama }}</strong>.
                    @endif
                </p>

                {{-- Show rejection reason for Pembimbing 2 --}}
                @if ($pengajuan2->status === 'ditolak' && !empty($pengajuan2->alasan_ditolak))
                    <div class="mt-3 p-3 bg-red-100 border-l-4 border-red-400 rounded">
                        <p class="text-sm text-red-700 font-medium">Alasan Penolakan:</p>
                        <p class="text-sm text-red-600 mt-1">{{ $pengajuan2->alasan_ditolak }}</p>
                    </div>
                @endif

                @if ($pengajuan2->status === 'ditolak')
                    <div class="text-sm text-gray-700 mt-3">
                        Silakan ajukan ulang untuk memilih Dosen Pembimbing 2 yang lain.
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Ajukan Ulang</a>
                    </div>
                @endif

                @if ($pengajuan2->status === 'diterima')
                    <div class="mt-2">
                        <a href="{{ route('detail.dosen', $pengajuan2->dosen->id_dosen) }}" class="inline-block text-sm bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600 transition">Lihat Kelas</a>
                    </div>
                @endif
            </div>
        @endif

        {{-- Show different messages based on status --}}
        @if (!$pengajuan1 && !$pengajuan2)
            <div class="text-center p-8">
                <div class="mb-4">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-lg text-gray-700 mb-2">Belum Ada Pengajuan</p>
                <p class="text-sm text-gray-500 mb-6">Anda belum melakukan pengajuan dosen pembimbing.</p>
                <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition font-medium">Ajukan Sekarang</a>
            </div>
        @elseif (($pengajuan1 && $pengajuan1->status === 'pending') || ($pengajuan2 && $pengajuan2->status === 'pending'))
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-blue-700 font-medium">Status: Menunggu Persetujuan</p>
                </div>
                <p class="text-sm text-blue-600 mt-1">Pengajuan Anda sedang dalam proses review oleh dosen pembimbing.</p>
            </div>
        @elseif (($pengajuan1 && $pengajuan1->status === 'diterima') && ($pengajuan2 && $pengajuan2->status === 'diterima'))
            <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-400 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-green-700 font-medium">Selamat! Semua Pengajuan Diterima</p>
                </div>
                <p class="text-sm text-green-600 mt-1">Kedua dosen pembimbing telah menyetujui pengajuan Anda. Anda dapat melanjutkan ke tahap bimbingan.</p>
                {{-- <div class="mt-3">
                    <a href="{{ url('/bimbingan') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">Mulai Bimbingan</a>
                </div> --}}
            </div>
        @endif
    </div>
</div>

<style>
.container {
    min-height: calc(100vh - 200px);
}
</style>
@endsection
