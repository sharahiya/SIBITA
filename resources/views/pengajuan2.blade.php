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
                @elseif ($pengajuan1->status === 'cancelled')
                    border-orange-500 bg-orange-50
                @else
                    border-yellow-500 bg-yellow-50
                @endif
                rounded">
                <h3 class="text-md font-medium
                    @if ($pengajuan1->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan1->status === 'ditolak')
                        text-red-700
                    @elseif ($pengajuan1->status === 'cancelled')
                        text-orange-700
                    @else
                        text-yellow-700
                    @endif
                ">Dosen Pembimbing 1</h3>

                <p class="text-sm
                    @if ($pengajuan1->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan1->status === 'ditolak')
                        text-red-700
                    @elseif ($pengajuan1->status === 'cancelled')
                        text-orange-700
                    @else
                        text-yellow-700
                    @endif
                ">
                    @if ($pengajuan1->status === 'cancelled')
                        Pengajuan Anda <strong>dibatalkan otomatis</strong>
                        @if ($pengajuan1->dosen)
                            dengan <strong>{{ $pengajuan1->dosen->nama }}</strong>.
                        @endif
                    @else
                        Pengajuan Anda <strong>{{ $pengajuan1->status }}</strong>
                        @if ($pengajuan1->dosen)
                            oleh <strong>{{ $pengajuan1->dosen->nama }}</strong>.
                        @endif
                    @endif
                </p>

                {{-- Show cancellation message --}}
                @if ($pengajuan1->status === 'cancelled')
                    <div class="mt-3 p-3 bg-orange-100 border-l-4 border-orange-400 rounded">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm text-orange-700 font-medium">Pengajuan Dibatalkan Otomatis</p>
                        </div>
                        <p class="text-sm text-orange-600">
                            Pengajuan telah dibatalkan karena dosen belum memberikan respons dalam 3 hari sejak pengajuan diajukan
                            ({{ \Carbon\Carbon::parse($pengajuan1->tanggal_pengajuan)->format('d M Y') }}).
                        </p>
                        @if (!empty($pengajuan1->keterangan))
                            <p class="text-xs text-orange-500 mt-2 italic">{{ $pengajuan1->keterangan }}</p>
                        @endif
                    </div>
                @endif

                {{-- Show rejection reason for Pembimbing 1 --}}
                @if ($pengajuan1->status === 'ditolak' && !empty($pengajuan1->alasan_ditolak))
                    <div class="mt-3 p-3 bg-red-100 border-l-4 border-red-400 rounded">
                        <p class="text-sm text-red-700 font-medium">Alasan Penolakan:</p>
                        <p class="text-sm text-red-600 mt-1">{{ $pengajuan1->alasan_ditolak }}</p>
                    </div>
                @endif

                {{-- Show resubmission option for rejected or cancelled --}}
                @if ($pengajuan1->status === 'ditolak' || $pengajuan1->status === 'cancelled')
                    <div class="text-sm text-gray-700 mt-3">
                        @if ($pengajuan1->status === 'cancelled')
                            Anda dapat mengajukan kembali kepada dosen yang sama atau memilih dosen pembimbing lain.
                        @else
                            Silakan ajukan ulang untuk memilih Dosen Pembimbing 1 yang lain.
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            @if ($pengajuan1->status === 'cancelled')
                                Ajukan Kembali
                            @else
                                Ajukan Ulang
                            @endif
                        </a>
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
                @elseif ($pengajuan2->status === 'cancelled')
                    border-orange-500 bg-orange-50
                @else
                    border-yellow-500 bg-yellow-50
                @endif
                rounded">
                <h3 class="text-md font-medium
                    @if ($pengajuan2->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan2->status === 'ditolak')
                        text-red-700
                    @elseif ($pengajuan2->status === 'cancelled')
                        text-orange-700
                    @else
                        text-yellow-700
                    @endif
                ">Dosen Pembimbing 2</h3>

                <p class="text-sm
                    @if ($pengajuan2->status === 'diterima')
                        text-green-700
                    @elseif ($pengajuan2->status === 'ditolak')
                        text-red-700
                    @elseif ($pengajuan2->status === 'cancelled')
                        text-orange-700
                    @else
                        text-yellow-700
                    @endif
                ">
                    @if ($pengajuan2->status === 'cancelled')
                        Pengajuan Anda <strong>dibatalkan otomatis</strong>
                        @if ($pengajuan2->dosen)
                            dengan <strong>{{ $pengajuan2->dosen->nama }}</strong>.
                        @endif
                    @else
                        Pengajuan Anda <strong>{{ $pengajuan2->status }}</strong>
                        @if ($pengajuan2->dosen)
                            oleh <strong>{{ $pengajuan2->dosen->nama }}</strong>.
                        @endif
                    @endif
                </p>

                {{-- Show cancellation message --}}
                @if ($pengajuan2->status === 'cancelled')
                    <div class="mt-3 p-3 bg-orange-100 border-l-4 border-orange-400 rounded">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm text-orange-700 font-medium">Pengajuan Dibatalkan Otomatis</p>
                        </div>
                        <p class="text-sm text-orange-600">
                            Pengajuan telah dibatalkan karena dosen belum memberikan respons dalam 3 hari sejak pengajuan diajukan
                            ({{ \Carbon\Carbon::parse($pengajuan2->tanggal_pengajuan)->format('d M Y') }}).
                        </p>
                        @if (!empty($pengajuan2->keterangan))
                            <p class="text-xs text-orange-500 mt-2 italic">{{ $pengajuan2->keterangan }}</p>
                        @endif
                    </div>
                @endif

                {{-- Show rejection reason for Pembimbing 2 --}}
                @if ($pengajuan2->status === 'ditolak' && !empty($pengajuan2->alasan_ditolak))
                    <div class="mt-3 p-3 bg-red-100 border-l-4 border-red-400 rounded">
                        <p class="text-sm text-red-700 font-medium">Alasan Penolakan:</p>
                        <p class="text-sm text-red-600 mt-1">{{ $pengajuan2->alasan_ditolak }}</p>
                    </div>
                @endif

                @if ($pengajuan2->status === 'ditolak' || $pengajuan2->status === 'cancelled')
                    <div class="text-sm text-gray-700 mt-3">
                        @if ($pengajuan2->status === 'cancelled')
                            Anda dapat mengajukan kembali kepada dosen yang sama atau memilih dosen pembimbing lain.
                        @else
                            Silakan ajukan ulang untuk memilih Dosen Pembimbing 2 yang lain.
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ url('/pengajuan') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            @if ($pengajuan2->status === 'cancelled')
                                Ajukan Kembali
                            @else
                                Ajukan Ulang
                            @endif
                        </a>
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
            @php
                $pendingCount = 0;
                $pendingDays = [];

                if ($pengajuan1 && $pengajuan1->status === 'pending') {
                    $pendingCount++;
                    $pendingDays[] = \Carbon\Carbon::parse($pengajuan1->tanggal_pengajuan)->diffInDays(now()) + 1;
                }

                if ($pengajuan2 && $pengajuan2->status === 'pending') {
                    $pendingCount++;
                    $pendingDays[] = \Carbon\Carbon::parse($pengajuan2->tanggal_pengajuan)->diffInDays(now()) + 1;
                }

                $maxDays = max($pendingDays);
                $daysLeft = 3 - $maxDays + 1;
            @endphp

            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-blue-700 font-medium">Status: Menunggu Persetujuan</p>
                </div>
                <p class="text-sm text-blue-600 mt-1">
                    Pengajuan Anda sedang dalam proses review oleh dosen pembimbing.
                </p>
                @if ($daysLeft > 0)
                    <div class="mt-2 p-2 bg-blue-100 rounded">
                        <p class="text-xs text-blue-700">
                            <strong>Sisa waktu:</strong> {{ $daysLeft }} hari lagi sebelum pengajuan dibatalkan otomatis.
                        </p>
                    </div>
                @else
                    <div class="mt-2 p-2 bg-orange-100 rounded">
                        <p class="text-xs text-orange-700">
                            <strong>Perhatian:</strong> Pengajuan akan segera dibatalkan otomatis karena sudah melewati batas waktu 3 hari.
                        </p>
                    </div>
                @endif
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
            </div>
        @elseif (($pengajuan1 && $pengajuan1->status === 'cancelled') || ($pengajuan2 && $pengajuan2->status === 'cancelled'))
            <div class="mt-6 p-4 bg-orange-50 border-l-4 border-orange-400 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-orange-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-orange-700 font-medium">Ada Pengajuan yang Dibatalkan</p>
                </div>
                <p class="text-sm text-orange-600 mt-1">
                    Beberapa pengajuan telah dibatalkan otomatis karena tidak ada respons dari dosen dalam 3 hari.
                    Silakan ajukan kembali untuk melanjutkan proses.
                </p>
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
