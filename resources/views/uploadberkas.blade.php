@extends('layouts.layoutmhs')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl space-y-6">
    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
  <!-- Header -->
<div class="bg-white p-6 shadow-md rounded-lg mb-6">
    <h1 class="text-xl font-extrabold text-gray-800">Tugas Akhir Mahasiswa</h1>
    <p class="text-sm text-gray-600">Informasi lengkap mengenai tugas akhir mahasiswa</p>
</div>
<!-- Data Mahasiswa -->
<div class="bg-white p-6 shadow rounded-xl mb-6 border border-gray-100">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">📘 Data Mahasiswa</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div>
            <p class="text-gray-500">Nama</p>
            <p class="text-gray-900 font-medium">{{ $mahasiswa->nama }}</p>
        </div>
        <div>
            <p class="text-gray-500">NPM</p>
            <p class="text-gray-900 font-medium">{{ $mahasiswa->npm }}</p>
        </div>
        <div>
            <p class="text-gray-500">Semester Sajian</p>
            <p class="text-gray-900 font-medium">Genap 2024</p>
        </div>
        <div>
            <p class="text-gray-500">Dosen Wali</p>
            <p class="text-gray-900 font-medium">{{ $mahasiswa->dosenWali->nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">NIP Dosen Wali</p>
            <p class="text-gray-900 font-medium">{{ $mahasiswa->dosenWali->nip ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- Informasi Tugas Akhir -->
<div class="bg-white p-6 shadow rounded-xl border border-gray-100">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">🎓 Informasi Tugas Akhir</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div>
            <p class="text-gray-500">Bidang Penelitian</p>
            <p class="text-gray-900 font-medium">{{ $pengajuan->bidang ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Judul TA</p>
            <p class="text-gray-900 font-medium">{{ $pengajuan->topik_ta ?? '-' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-gray-500">Deskripsi</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $pengajuan->deskripsi_ta ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Dosen Pembimbing 1</p>
            <p class="text-gray-900 font-medium">{{ $dospem1->nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">Dosen Pembimbing 2</p>
            <p class="text-gray-900 font-medium">{{ $dospem2->nama ?? '-' }}</p>
        </div>
    </div>
</div>


    <!-- Upload Berkas -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-sm font-extrabold text-gray-800 mb-4">Upload Berkas</h2> <!-- Judul lebih tegas -->
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6 text-sm text-gray-700">
            <!-- Berkas Sempro -->
            <div x-data="{ modalSempro: false }"> <!-- Pindahkan x-data ke sini -->
                <label class="font-bold block mb-1 text-blue-600">Bukti Seminar Proposal (JPG/PNG)</label>

                @if($sempro && $sempro->lampiran)
                    <p class="text-sm mb-1">
                        ✅ <span class="text-gray-700">Sudah diunggah:</span>
                        <!-- Tombol untuk membuka modal -->
                        <button type="button" @click="modalSempro = true"
                            class="text-blue-600 underline hover:text-blue-800">
                            Lihat Berkas
                        </button>
                    </p>

                    <!-- Modal -->
                    <div x-show="modalSempro"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-4 max-w-md mx-auto">
                            <img src="{{ asset('storage/' . $sempro->lampiran) }}"
                                alt="Lampiran Sempro"
                                class="max-w-full max-h-[80vh] rounded">
                            <button @click="modalSempro = false"
                                class="mt-4 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Berkas Semhas -->
            <div>
                <div x-data="{ modalSemhas: false }">
                <label class="font-bold block mb-1 text-blue-600">Bukti Seminar Proposal (JPG/PNG)</label>

                @if($semhas && $semhas->lampiran)
                    <p class="text-sm mb-1">
                        ✅ <span class="text-gray-700">Sudah diunggah:</span>
                        <button type="button" @click="modalSemhas = true"
                            class="text-blue-600 underline hover:text-blue-800">
                            Lihat Berkas
                        </button>
                    </p>

                    <!-- Modal -->
                    <div x-show="modalSemhas"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-4 max-w-md mx-auto">
                            <img src="{{ asset('storage/' . $semhas->lampiran) }}"
                                alt="Lampiran Semhas"
                                class="max-w-full max-h-[80vh] rounded">
                            <button @click="modalSemhas = false"
                                class="mt-4 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                    </div>

                    <p class="text-sm mt-1">
                        Status:
                        @if($semhas->status == 'pending')
                            <span class="text-yellow-600 font-semibold">Menunggu Verifikasi</span>
                        @elseif($semhas->status == 'selesai' || $semhas->status == 'diterima')
                            <span class="text-green-600 font-semibold">Diterima</span>
                        @elseif($semhas->status == 'ditolak')
                            <span class="text-red-600 font-semibold">Ditolak</span>

                            @if(app()->environment('local')) {{-- Hanya di lokal --}}
                            <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <input type="hidden" name="jenis" value="hasil">
                                <input type="file" name="berkas" accept=".jpg,.jpeg,.png"
                                       class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
                                <button type="submit" class="bg-red-600 text-white mt-2 px-4 py-1 rounded hover:bg-red-700">
                                    Ajukan Ulang
                                </button>
                            </form>
                            @endif

                        @else
                            <span class="text-gray-600 italic">Tidak diketahui</span>
                        @endif
                    </p>
                @else
                    <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis" value="hasil">
                        <input type="file" name="berkas" accept=".jpg,.jpeg,.png"
                               class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        <button type="submit" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Upload
                        </button>
                    </form>
                @endif
            </div>

            <!-- Berkas Sidang -->
            <div>
                <div x-data="{ modalSidang: false }">
                <label class="font-bold block mb-1 text-blue-600">Bukti Seminar Proposal (JPG/PNG)</label>

                @if($sidang && $sidang->lampiran)
                    <p class="text-sm mb-1">
                        ✅ <span class="text-gray-700">Sudah diunggah:</span>
                        <button type="button" @click="modalSidang = true"
                        class="text-blue-600 underline hover:text-blue-800">
                        Lihat Berkas
                    </button>
                </p>

                <!-- Modal -->
                <div x-show="modalSidang"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-4 max-w-md mx-auto">
                        <img src="{{ asset('storage/' . $sidang->lampiran) }}"
                            alt="Lampiran Sidang"
                            class="max-w-full max-h-[80vh] rounded">
                        <button @click="modalSidang = false"
                            class="mt-4 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                            Tutup
                        </button>
                    </div>
                </div>
                </div>

                    <p class="text-sm mt-1">
                        Status:
                        @if($sidang->status == 'pending')
                            <span class="text-yellow-600 font-semibold">Menunggu Verifikasi</span>
                        @elseif($sidang->status == 'selesai' || $sidang->status == 'diterima')
                            <span class="text-green-600 font-semibold">Diterima</span>
                        @elseif($sidang->status == 'ditolak')
                            <span class="text-red-600 font-semibold">Ditolak</span>

                            @if(app()->environment('local')) {{-- Hanya di lokal --}}
                            <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <input type="hidden" name="jenis" value="sidang">
                                <input type="file" name="berkas" accept=".jpg,.jpeg,.png"
                                       class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
                                <button type="submit" class="bg-red-600 text-white mt-2 px-4 py-1 rounded hover:bg-red-700">
                                    Ajukan Ulang
                                </button>
                            </form>
                            @endif

                        @else
                            <span class="text-gray-600 italic">Tidak diketahui</span>
                        @endif
                    </p>
                @else
                    <form action="{{ route('upload.berkas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis" value="sidang">
                        <input type="file" name="berkas" accept=".jpg,.jpeg,.png"
                               class="w-full file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        <button type="submit" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Upload
                        </button>
                    </form>
                @endif
            </div>


        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


@endsection
