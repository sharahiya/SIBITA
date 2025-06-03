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

                @if ($pengajuan1->status === 'ditolak' && !empty($pengajuan1->alasan_ditolak))
                    <p class="text-xs text-red-600 italic mt-1">
                        Alasan: {{ $pengajuan1->alasan_ditolak }}
                    </p>
                @endif
                @if ($pengajuan2->status === 'ditolak')
                    <div class="text-sm text-gray-700 mt-2">
                        Silakan ajukan ulang untuk memilih Dosen Pembimbing 2 yang lain.
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

                @if ($pengajuan2->status === 'ditolak' && !empty($pengajuan2->alasan_ditolak))
                    <p class="text-xs text-red-600 italic mt-1">
                        Alasan: {{ $pengajuan2->alasan_ditolak }}
                    </p>
                @endif

                @if ($pengajuan2->status === 'ditolak')
                    <div class="text-sm text-gray-700 mt-2">
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

        @if (!$pengajuan1 && !$pengajuan2)
            <p class="text-sm text-gray-700">Anda belum melakukan pengajuan dosen pembimbing.</p>
            <div class="mt-4 text-center">
                <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Ajukan Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection
